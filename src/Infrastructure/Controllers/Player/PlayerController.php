<?php

namespace App\Infrastructure\Controllers\Player;

use App\Application\Player\GetPlayers;
use App\Application\Player\AddPlayer;
use App\Application\Player\RemovePlayer;
use App\Domain\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * 
     * @Route("/addPlayer", name="app_add_player")
     * 
     * @return Response
     * 
     */
    public function add(): Response
    {
        return $this->render('player/add--or--update--player.html.twig', []);
    }


    /**
     * 
     * @Route("/addPlayerSubmitAction", name="app_add_player_submit")
     * 
     * @return Response
     * 
     */
    public function addSubmitAction(Request $request, AddPlayer\CommandHandler $useCase): Response
    {

        $data = (object)[
            'playerName'    => $request->get('playerName'),
            'salary'        => (float)$request->get('salary'),
            'position'      => $request->get('playerPosition')
        ];

        $command = new AddPlayer\Command($data);

        try {
            $useCase($command);
        } catch (EntityNotFoundException $e) {
            return $e->getMessage();
        }


        return $this->redirectToRoute('app_player');
    }

        /**
     * 
     * @Route("/removeSubmitAction", name="app_remove_player")
     * 
     * @return Response
     * 
     */
    public function removeSubmitAction(Request $request, RemovePlayer\CommandHandler $useCase): Response
    {

        $data = (object)[
            'playerId' => (int)$request->get('id'),
        ];

        $command = new RemovePlayer\Command($data);

        try {
            $useCase($command);
            $success = true;
        } catch (EntityNotFoundException $e) {
            $message = $e->getMessage();
            $success = false;
        }


        return $this->json(
            [
                'success'   => $success,
                'message'   => (!empty($message)) ? $message : ''
            ],
            ($success) ? 200 : 400
        );
    }

}
