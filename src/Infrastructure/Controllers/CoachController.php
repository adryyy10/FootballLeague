<?php

namespace App\Infrastructure\Controllers;

use App\Application\Coach\GetCoaches\QueryHandler as getCoachesUseCase;
use App\Application\Club\GetClubs\QueryHandler as getClubsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
     * @Route("/coaches", name="app_coach")
     */
    public function listingCoaches(getCoachesUseCase $useCase): Response
    {
        
        $response = $useCase();

        return $this->render('coach/index.html.twig', [
            'coaches'           => $response->getCoaches()
        ]);
    }

    /**
     * @Route("/addCoach", name="app_add_coach")
     */
    public function addCoach(getClubsUseCase $useCase): Response
    {
        $response = $useCase();
        
        return $this->render('coach/add--coach.html.twig', [
            'clubs'             => $response->getClubs()
        ]);
    }
}
