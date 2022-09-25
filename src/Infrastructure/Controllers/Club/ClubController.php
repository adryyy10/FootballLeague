<?php

namespace App\Infrastructure\Controllers\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
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


}
