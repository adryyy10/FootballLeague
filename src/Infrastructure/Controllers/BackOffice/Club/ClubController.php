<?php

namespace App\Infrastructure\Controllers\BackOffice\Club;

use App\Application\Club\AddClub;
use App\Application\Club\DeleteClub;
use App\Application\Club\GetClubs;
use App\Application\Coach\GetCoachesWithNoClub;
use App\Domain\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ClubController extends AbstractController
{

    /**
     * @Route("/admin/clubs", name="app_admin_club")
     * 
     * @param GetClubs\QueryHandler
     * 
     * @return Response
     */
    public function list(GetClubs\QueryHandler $useCase): Response
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        // Get list of clubs via useCase and retrieve them with the $response->getClubs()
        $response = $useCase();

        return $this->render('BackOffice/club/index.html.twig', [
            'clubs' => $response->getClubs()
        ]);
    }

    /**
     * @Route("/addClub", name="app_admin_add_club")
     * 
     * @param GetCoachesWithNoClub\QueryHandler
     * 
     * @return Response
     */
    public function add(GetCoachesWithNoClub\QueryHandler $getCoachesByNoClubUseCase): Response
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        // Get all the coaches that have no club to show them in the dropdown
        $getClubsResponse = $getCoachesByNoClubUseCase();
        
        return $this->render('BackOffice/club/add--or--update--club.html.twig', [
            'coaches' => $getClubsResponse->getCoaches()
        ]);
    }

    /**
     * @Route("/addClubSubmitAction", name="app_admin_add_club_submit")
     * 
     * @param Request
     * @param AddClub\CommandHandler
     * 
     * @return Response
     * @throws EntityNotFoundException
     */
    public function addSubmitAction(Request $request,AddClub\CommandHandler $addClubUseCase): Response
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

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
     * @Route("/removeClubAction", name="app_admin_remove_club")
     * 
     * @param Request
     * @param DeleteClub\CommandHandler
     * 
     * @return JsonReponse
     * @throws EntityNotFoundException
     */
    public function removeSubmitAction(Request $request, DeleteClub\CommandHandler $deleteClubUseCase)
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

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
