<?php

namespace App\Infrastructure\Controllers\BackOffice\Coach;

use App\Application\Club\GetClubsWithNoCoach;
use App\Application\Coach\AddCoach;
use App\Application\Coach\DeleteCoach;
use App\Application\Coach\GetCoach;
use App\Application\Coach\GetCoaches;
use App\Domain\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        // Get list of Coaches via useCase where we can show them with the $response->getCoaches()
        $response = $useCase();

        return $this->render('BackOffice/coach/index.html.twig', [
            'coaches' => $response->getCoaches()
        ]);
    }

    /**
     * @Route("/addCoach", name="app_admin_add_coach")
     * 
     * @param GetClubsWithNoCoach\QueryHandler $getClubsWithNoCoachUseCase
     * 
     * @return Response
     */
    public function add(): Response
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        return $this->render('BackOffice/coach/add--or--update--coach.html.twig', []);
    }

    
    /**
     * @Route("/addCoachSubmitAction", name="app_admin_add_coach_submit")
     * 
     * @param Request $request
     * @param AddCoach\CommandHandler $addCoachUseCase
     * 
     * @throws EntityNotFoundException
     */
    public function addSubmitAction(Request $request, AddCoach\CommandHandler $addCoachUseCase)
    {
        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        // Get data from the form via $request
        $coachId    = $request->get('coachId');
        $coachName  = $request->get('coachName');
        $salary     = $request->get('salary');
        $clubId     = $request->get('club');

        // Create array $data to pass it to Command
        $data = [
            'coachId'   => (empty($coachId) ? null : (int)$coachId),
            'coachName' => $coachName,
            'salary'    => (float)$salary,
            'clubId'    => $clubId
        ];

        // Instantiate new AddCoach\Command and pass data to validate 
        // typos and check if are mandatory or not
        $command = new AddCoach\Command((object)$data);

        // Add new Coach
        try{
            $addCoachUseCase($command);
        } catch (EntityNotFoundException $e) {
            return $e->getMessage();
        }
        
        // After a coach is added, redirect to coach listing
        return $this->redirectToRoute('app_admin_coach');
    }

    /**
     * @Route("/updateCoach/{id}", name="app_admin_update_coach")
     * 
     * @param GetCoach\QueryHandler
     * @param int $coachId
     * 
     * @return Response
     */
    public function update(GetCoach\QueryHandler $getCoachUseCase, int $coachId): Response
    {

        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        $data = [
            'coachId' => $coachId
        ];

        // Instantiate new GetCoach\Query and pass data to validate 
        // typos and check if are mandatory or not
        $command = new GetCoach\Query((object)$data);

        // Find Coach
        $getCoachResponse = $getCoachUseCase($command);
        
        return $this->render('BackOffice/coach/add--or--update--coach.html.twig', [
            'coach' => $getCoachResponse->getCoach()
        ]);
    }

    /**
     * @Route("/removeCoachAction", name="app_admin_remove_coach")
     * 
     * @param Request $request
     */
    public function removeSubmitAction(Request $request, DeleteCoach\CommandHandler $deleteCoachUseCase)
    {
        
        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        $coachId = $request->get('id');

        $data = [
            'coachId' => (int)$coachId
        ];

        // Instantiate new DeleteCoach\Command and pass data to validate 
        // typos and check if are mandatory or not
        $command = new DeleteCoach\Command((object)$data);

        // Delete Coach
        try {
            $deleteCoachUseCase($command);
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
