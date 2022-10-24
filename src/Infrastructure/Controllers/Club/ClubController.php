<?php

namespace App\Infrastructure\Controllers\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Club\AddClub;
use App\Application\Club\GetClubsWithNoCoach;
use App\Application\Club\GetClub;
use App\Application\Coach\GetCoaches;
use App\Application\Club\DeleteClub;
use App\Domain\Exceptions\EntityNotFoundException;

class ClubController extends AbstractController
{

    /**
     * @Route("/clubs", name="app_club")
     * 
     * @param GetClubs\QueryHandler
     * @return GetClubs\Response
     */
    public function listingClubs(GetClubs\QueryHandler $useCase): Response
    {
        // We get our list of clubs via useCase where we can show them with the $response->getClubs()
        $response = $useCase();

        return $this->render('club/index.html.twig', [
            'clubs' => $response->getClubs()
        ]);
    }

    /**
     * @Route("/addClub", name="app_add_club")
     * 
     * @param GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase
     * @return Response
     */
    public function addClub(
        GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase
    ): Response
    {
        // We must get all the clubs to be able to show them in the form
        $getClubsResponse = $getCoachesByNoClubUseCase();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches' => $getClubsResponse->getCoaches()
        ]);
    }

    /**
     * @Route("/addClubSubmitAction", name="app_add_club_submit")
     * 
     * @param AddClub\CommandHandler $addClubUseCase
     * @return Response
     */
    public function addClubSubmitAction(
        AddClub\CommandHandler $addClubUseCase,
        Request $request
    ): Response
    {
        // We get the data from the form via $request
        $clubId     = $request->get('clubId');
        $clubName   = $request->get('clubName');
        $budget     = $request->get('budget');
        $coachId    = $request->get('coachId');

        // We create an array $data just to pass it to our Command
        $data = [
            'clubId'    => (empty($clubId) ? null : (int)$clubId),
            'clubName'  => $clubName,
            'budget'    => (float)$budget,
            'coachId'   => (int)$coachId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new AddClub\Command((object)$data);

        // We add a new coach with our useCase and get a Json response
        $addClubUseCase($command);
        
        // After a club is added, we redirect to our club listing
        return $this->redirectToRoute('app_club');
    }

        /**
     * @Route("/updateCoach/{id}", name="app_update_coach")
     * 
     * @param Request $request
     * @param GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
     * @param GetCoach\QueryHandler $getCoachUseCase
     * 
     * @return Response
     */
    public function updateClub(
        GetCoaches\QueryHandler $getCoaches,
        GetClub\QueryHandler $getClubUseCase,
        int $clubId
    ): Response
    {
        $data = [
            'clubId' => $clubId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new GetClub\Query((object)$data);
        // We need to find Coach and update it
        $getClubResponse = $getClubUseCase($command);
        // We must get all the clubs to be able to show them in the form
        $getCoachesResponse = $getCoaches();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches'   => $getCoachesResponse->getCoaches(),
            'club'      => $getClubResponse->getClub()
        ]);
    }

    /**
     * @Route("/removeClubAction", name="app_remove_club")
     * 
     * @param Request $request
     */
    public function removeClubAction(Request $request, DeleteClub\CommandHandler $deleteClubUseCase)
    {
        $clubId = $request->get('id');

        $data = [
            'clubId' => (int)$clubId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new DeleteClub\Command((object)$data);

        try {
            $deleteClubUseCase($command);
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
