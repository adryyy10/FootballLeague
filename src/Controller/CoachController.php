<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Coach;
use App\Repository\CoachRepository;
use Doctrine\Persistence\ManagerRegistry;

class CoachController extends AbstractController
{
    /**
     * @Route("/coach", name="app_coach")
     */
    public function index(ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();

        $newCoach = new Coach();
        $newCoach->setName('Guardiola');
        $newCoach->setSalary(102.8);
        $newCoach->setClub('Man city');

        $entityManager->persist($newCoach);
        $entityManager->flush();


        return $this->render('coach/index.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }
}
