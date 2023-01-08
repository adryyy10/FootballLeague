<?php

namespace App\Infrastructure\Controllers\Club;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Club\AddClub;
use App\Application\Club\GetClubById;
use App\Application\Club\GetClubBySlug;
use App\Application\Coach\GetCoaches;
use App\Application\Club\DeleteClub;
use App\Domain\Exceptions\EntityNotFoundException;

class ClubController extends AbstractController
{

    /**
     * @Route("/clubs", name="app_club")
     * 
     * @param GetClubs\QueryHandler
     * 
     * @return Response
     */
    public function list(GetClubs\QueryHandler $useCase): Response
    {
        // Get list of clubs via useCase where we can show them with the $response->getClubs()
        $response = $useCase();

        return $this->render('club/index.html.twig', [
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

        return $this->render('club/club.html.twig', [
            'club' => $response->getClub()
        ]);
    }

    /**
     * @Route("/addClub", name="app_add_club")
     * 
     * @param GetCoachesWithNoClub\QueryHandler
     * 
     * @return Response
     */
    public function add(GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase): Response
    {
        // Get all the coaches that have no club to show them in the dropdown
        $getClubsResponse = $getCoachesByNoClubUseCase();
        
        return $this->render('club/add--or--update--club.html.twig', [
            'coaches' => $getClubsResponse->getCoaches()
        ]);
    }

    /**
     * @Route("/addClubSubmitAction", name="app_add_club_submit")
     * 
     * @param Request
     * @param AddClub\CommandHandler
     * 
     * @return Response
     * @throws EntityNotFoundException
     */
    public function addSubmitAction(Request $request,AddClub\CommandHandler $addClubUseCase): Response
    {
        // Get data from the form via $request
        $clubId     = $request->get('clubId');
        $clubName   = $request->get('clubName');
        $budget     = $request->get('budget');
        $coachId    = $request->get('coachId');
        $stadiumId  = $request->get('stadiumId');
        $palette    = $request->get('palette');
        $slug       = $request->get('slug');

        // Create array $data just to pass it to Command
        $data = [
            'clubId'    => (empty($clubId) ? null : (int)$clubId),
            'clubName'  => $clubName,
            'budget'    => (float)$budget,
            'coachId'   => (int)$coachId,
            'stadiumId' => (int)$stadiumId,
            'palette'   => $palette,
            'slug'      => $slug
        ];

        // Instantiate new AddClub\Command and pass data to validate 
        // typos and check if are mandatory or not
        $command = new AddClub\Command((object)$data);

        // Add new Club
        try {
            $addClubUseCase($command);
        } catch (EntityNotFoundException $e) {
            return $e->getMessage();
        }
        
        // After a club is added, redirect to club listing
        return $this->redirectToRoute('app_club');
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

    /**
     * @Route("/removeClubAction", name="app_remove_club")
     * 
     * @param Request
     * @param DeleteClub\CommandHandler
     * 
     * @return JsonReponse
     * @throws EntityNotFoundException
     */
    public function removeSubmitAction(Request $request, DeleteClub\CommandHandler $deleteClubUseCase)
    {
        $clubId = $request->get('id');

        $data = [
            'clubId' => (int)$clubId,
            'slug'   => $request->get('slug')
        ];

        $command = new DeleteClub\Command((object)$data);

        try {
            $deleteClubUseCase($command);
            $success = true;
        } catch (EntityNotFoundException $e) {
            $success = false;
            $message = $e;
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
