<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Coach;
use Doctrine\Persistence\ManagerRegistry;

class CoachController extends AbstractController
{
    /**
     * @Route("/coach", name="app_coach")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Coach::class);
        $coaches    = $repository->findAll();

        return $this->render('coach/index.html.twig', [
            'controller_name'   => 'CoachController',
            'coaches'           => $coaches,
        ]);
    }
}
