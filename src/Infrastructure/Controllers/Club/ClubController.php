<?php

namespace App\Infrastructure\Controllers\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Club\AddClub;
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
     * 
     * @return Response
     */
    public function list(GetClubs\QueryHandler $useCase): Response
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
     * @param GetCoachesWithNoClub\QueryHandler
     * 
     * @return Response
     */
    public function add(GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase): Response
    {
        // We must get all the coaches that has no club to show them in the dropdown
        $getClubsResponse = $getCoachesByNoClubUseCase();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches' => $getClubsResponse->getCoaches()
        ]);
    }

    /**
     * @Route("/addClubSubmitAction", name="app_add_club_submit")
     * 
     * @param Request
     * @param AddClub\CommandHandler
     * 
     * @return Response
     * @throws EntityNotFoundException
     */
    public function addSubmitAction(Request $request,AddClub\CommandHandler $addClubUseCase): Response
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

        // We instantiate a new AddClub\Command and pass the data to validate 
        // the typos of the data and if they are mandatory or not
        $command = new AddClub\Command((object)$data);

        // Add new Club
        try {
            $addClubUseCase($command);
        } catch (EntityNotFoundException $e) {
            return $e->getMessage();
        }
        
        // After a club is added, we redirect to our club listing
        return $this->redirectToRoute('app_club');
    }

    /**
     * @Route("/updateCoach/{id}", name="app_update_coach")
     * 
     * @param GetCoaches\QueryHandler
     * @param GetClub\QueryHandler
     * @param int $clubId
     * 
     * @return Response
     */
    public function update(
        GetCoaches\QueryHandler $getCoaches,
        GetClub\QueryHandler $getClubUseCase,
        int $clubId
    ): Response
    {
        $data = [
            'clubId' => $clubId
        ];

        // We instantiate a new GetClub\Query and pass the data to validate 
        // the typos of the data and if they are mandatory or not
        $command = new GetClub\Query((object)$data);

        // We need to find the Club first
        $getClubResponse = $getClubUseCase($command);

        // We must get all the Coaches to show them in the dropdown
        $getCoachesResponse = $getCoaches();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches'   => $getCoachesResponse->getCoaches(),
            'club'      => $getClubResponse->getClub()
        ]);
    }

    /**
     * @Route("/removeClubAction", name="app_remove_club")
     * 
     * @param Request
     * @param DeleteClub\CommandHandler
     * 
     * @return JsonReponse
     * @throws EntityNotFoundException
     */
    public function removeSubmitAction(Request $request, DeleteClub\CommandHandler $deleteClubUseCase)
    {
        $clubId = $request->get('id');

        $data = [
            'clubId' => (int)$clubId
        ];

        // We instantiate a new DeleteClub\Command and pass the data to validate 
        // the typos of the data and if they are mandatory or not
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
