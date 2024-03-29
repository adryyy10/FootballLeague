<?php

namespace App\Infrastructure\Controllers\Website\Player;

use App\Application\Player\GetPlayers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{

    /**
     * 
     * @Route("/players", name="app_player")
     * 
     * @param GetPlayers\QueryHandler $useCase
     * 
     * @return Response
     * 
     */
    public function list(GetPlayers\QueryHandler $useCase): Response
    {
        $useCaseResponse = $useCase();

        return $this->render('player/index.html.twig', [
            'players' => $useCaseResponse->getPlayers()
        ]);
    }
}
