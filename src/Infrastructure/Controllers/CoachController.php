<?php

namespace App\Infrastructure\Controllers;

use App\Application\Coach\GetCoaches\QueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class CoachController extends AbstractController
{
    /**
     * @Route("/coaches", name="app_coach")
     */
    public function listingCoaches(QueryHandler $useCase): Response
    {
        
        $response = $useCase();

        return $this->render('coach/index.html.twig', [
            'controller_name'   => 'CoachController',
            'coaches'           => $response->getCoaches()
        ]);
    }

    /**
     * @Route("/addCoach", name="app_add_coach")
     */
    public function addCoach()
    {
        $test = 1;
        return $this->render('coach/add--coach.html.twig', [
            'controller_name'   => 'CoachController',
            'test'              => $test
        ]);
    }
}
