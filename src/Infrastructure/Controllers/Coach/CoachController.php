<?php

namespace App\Infrastructure\Controllers\Coach;

use App\Application\Coach\GetCoaches\QueryHandler as getCoachesUseCase;
use App\Application\Club\GetClubsWithNoCoach;
use App\Application\Coach\AddCoach;
use App\Application\Coach\DeleteCoach;
use App\Application\Coach\GetCoach;
use App\Domain\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
     * @Route("/coaches", name="app_coach")
     * 
     * @param getCoachesUseCase $useCase
     * @return Response
     */
    public function listingCoaches(getCoachesUseCase $useCase): Response
    {
        // We get our list of coaches via useCase where we can show them with the $response->getCoaches()
        $response = $useCase();

        return $this->render('coach/index.html.twig', [
            'coaches'           => $response->getCoaches()
        ]);
    }

    /**
     * @Route("/addCoach", name="app_add_coach")
     * 
     * @param GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
     * @return Response
     */
    public function addCoach(
        Request $request,
        GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
    ): Response
    {
        // We must get all the clubs to be able to show them in the form
        $getClubsResponse = $getClubsWithNoCoachUseCase();
        
        return $this->render('coach/add--or--update--coach.html.twig', [
            'clubs' => $getClubsResponse->getClubs()
        ]);
    }

    /**
     * @Route("/updateCoach/{id}", name="app_update_coach")
     * 
     * @param GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
     * @param GetCoach\QueryHandler $getCoachUseCase
     * 
     * @return Response
     */
    public function updateCoach(
        GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase,
        GetCoach\QueryHandler $getCoachUseCase,
        int $coachId
    ): Response
    {
        $data = [
            'coachId' => $coachId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new GetCoach\Query((object)$data);
        // We need to find Coach and update it
        $getCoachResponse = $getCoachUseCase($command);
        // We must get all the clubs to be able to show them in the form
        $getClubsResponse = $getClubsWithNoCoachUseCase();
        
        return $this->render('coach/add--or--update--coach.html.twig', [
            'clubs' => $getClubsResponse->getClubs(),
            'coach' => $getCoachResponse->getCoach()
        ]);
    }

    /**
     * @Route("/addCoachSubmitAction", name="app_add_coach_submit")
     * 
     * @param Request $request
     * @param AddCoach\CommandHandler $addCoachUseCase
     */
    public function addCoachSubmitAction(Request $request, AddCoach\CommandHandler $addCoachUseCase)
    {
        // We get the data from the form via $request
        $coachId    = $request->get('coachId');
        $coachName  = $request->get('coachName');
        $salary     = $request->get('salary');
        $clubId     = $request->get('club');

        // We create an array $data just to pass it to our Command
        $data = (object)[
            'coachId'   => (empty($coachId) ? null : (int)$coachId),
            'coachName' => $coachName,
            'salary'    => (float)$salary,
            'clubId'    => $clubId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new AddCoach\Command($data);

        // We add a new coach with our useCase and get a Json response
        $addCoachUseCase($command);
        
        // After a coach is added, we redirect to our coach listing
        return $this->redirectToRoute('app_coach');
    }

    /**
     * @Route("/removeCoachAction", name="app_remove_coach")
     * 
     * @param Request $request
     */
    public function removeCoachAction(Request $request, DeleteCoach\CommandHandler $deleteCoachUseCase)
    {
        $coachId = $request->get('id');

        $data = [
            'coachId' => (int)$coachId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new DeleteCoach\Command((object)$data);

        try {
            $deleteCoachUseCase($command);
            $success = true;
        } catch (EntityNotFoundException $e) {
            $success = false;
            $message = $e;
        }

        return $this->json(
            [
                'success'   => $success,
                'message'   => (!empty($message)) ? $message : ''
            ],
            ($success) ? 200 : 400
        );
    }
}
