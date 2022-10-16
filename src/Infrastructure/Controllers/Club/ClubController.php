<?php

namespace App\Infrastructure\Controllers\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Club\AddClubs;

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
     * @param GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase
     * @return Response
     */
    public function addClubSubmitAction(
        AddClubs\CommandHandler $addClubUseCase,
        Request $request
    ): Response
    {

        // We get the data from the form via $request
        $clubId     = $request->get('clubId', null);
        $clubName   = $request->get('clubName');
        $budget     = $request->get('budget');
        $coachId    = $request->get('coachId');

        // We create an array $data just to pass it to our Command
        $data = [
            'clubId'    => (int)$clubId,
            'clubName'  => $clubName,
            'budget'    => $budget,
            'coachId'   => (int)$coachId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new AddClubs\Command($data);

        // We add a new coach with our useCase and get a Json response
        $addClubUseCase($command);
        
        // After a club is added, we redirect to our club listing
        return $this->redirectToRoute('app_club');
    }


}
