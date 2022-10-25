<?php

namespace App\Infrastructure\Controllers\Player;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Player\GetPlayers;

class PlayerController extends AbstractController
{

    public function list(GetPlayers\QueryHandler $useCase): Response
    {
        $useCaseResponse = $useCase();

        return $this->render('', [
            'players' => $useCaseResponse->getPlayers()
        ]);
    }

}
