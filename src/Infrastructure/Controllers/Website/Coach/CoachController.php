<?php

namespace App\Infrastructure\Controllers\Website\Coach;

use App\Application\Coach\GetCoaches;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
     * @Route("/coaches", name="app_website_coach")
     * 
     * @param GetCoaches\QueryHandler
     * 
     * @return Response
     */
    public function list(GetCoaches\QueryHandler $useCase): Response
    {
        // Get list of Coaches via useCase and show them with the $response->getCoaches()
        $response = $useCase();

        return $this->render('Website/coach/index.html.twig', [
            'coaches' => $response->getCoaches()
        ]);
    }
}
