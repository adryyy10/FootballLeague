<?php

namespace App\Infrastructure\Controllers\Website\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Club\GetClubById;
use App\Application\Club\GetClubBySlug;
use App\Application\Coach\GetCoaches;

class ClubController extends AbstractController
{

    /**
     * @Route("/clubs", name="app_website_club")
     * 
     * @param GetClubs\QueryHandler
     * 
     * @return Response
     */
    public function list(GetClubs\QueryHandler $useCase): Response
    {
        // Get list of clubs via useCase where we can show them with the $response->getClubs()
        $response = $useCase();

        return $this->render('Website/club/index.html.twig', [
            'clubs' => $response->getClubs()
        ]);
    }

    /**
     * @Route("/clubs/{slug}", name="app_get_club")
     * 
     * @param string $slug
     * @param GetClubBySlug\QueryHandler
     * 
     * @return Response
     */
    public function getClub(string $slug, GetClubBySlug\QueryHandler $useCase): Response
    {
        $data = [
            'slug' => $slug
        ];

        // Instantiate new GetClubbySlug\Query and pass data to validate 
        // typos and check if are mandatory or not
        $command = new GetClubbySlug\Query((object)$data);

        $response = $useCase($command);

        return $this->render('Website/club/club.html.twig', [
            'club' => $response->getClub()
        ]);
    }

    /**
     * @Route("/updateCoach/{id}", name="app_update_coach")
     * 
     * @param GetCoaches\QueryHandler
     * @param GetClubById\QueryHandler
     * @param int $clubId
     * 
     * @return Response
     */
    /*public function update(
        GetCoaches\QueryHandler $getCoaches,
        GetClubById\QueryHandler $getClubUseCase,
        int $clubId
    ): Response
    {
        $data = [
            'clubId' => $clubId
        ];

        // Instantiate new GetClubById\Query and pass data to validate 
        // typos and check if are mandatory or not
        $command = new GetClubById\Query((object)$data);

        // Find Club
        $getClubResponse = $getClubUseCase($command);

        // Get all coaches to show in the dropdown
        $getCoachesResponse = $getCoaches();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches'   => $getCoachesResponse->getCoaches(),
            'club'      => $getClubResponse->getClub()
        ]);
    }*/

}
