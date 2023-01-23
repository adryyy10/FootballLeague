<?php

namespace App\Infrastructure\Controllers\BackOffice\Coach;

use App\Application\Coach\GetCoaches;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{

    /**
     * @Route("/admin/coaches", name="app_admin_coach")
     * 
     * @param GetCoaches\QueryHandler
     * 
     * @return Response
     */
    public function list(GetCoaches\QueryHandler $useCase): Response
    {
        // Get list of Coaches via useCase where we can show them with the $response->getCoaches()
        $response = $useCase();

        return $this->render('BackOffice/coach/index.html.twig', [
            'coaches' => $response->getCoaches()
        ]);
    }

}
