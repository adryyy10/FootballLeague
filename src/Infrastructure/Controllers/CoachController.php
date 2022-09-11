<?php

namespace App\Infrastructure\Controllers;

use App\Application\Coach\GetCoaches\QueryHandler as getCoachesUseCase;
use App\Application\Club\GetClubs\QueryHandler as getClubsUseCase;
use App\Application\Coach\AddCoaches;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
     * @Route("/coaches", name="app_coach")
     * 
     * @param getCoachesUseCase $useCase
     * @return Response
     */
    public function listingCoaches(getCoachesUseCase $useCase): Response
    {
        // We get our list of coaches via useCase where we can show them with the $response->getCoaches()
        $response = $useCase();
        dd($response->getCoaches());

        return $this->render('coach/index.html.twig', [
            'coaches'           => $response->getCoaches()
        ]);
    }

    /**
     * @Route("/addCoach", name="app_add_coach")
     * 
     * @param getClubsUseCase $useCase
     * @return Response
     */
    public function addCoach(getClubsUseCase $useCase): Response
    {
        // In order to add a new coach, we must get all the clubs to be able to show them in the form
        $response = $useCase();
        
        return $this->render('coach/add--coach.html.twig', [
            'clubs'             => $response->getClubs()
        ]);
    }

    /**
     * @Route("/addCoachSubmitAction", name="app_add_coach_submit")
     * 
     * @param Request $request
     * @param AddCoaches\CommandHandler $addCoachUseCase
     */
    public function addCoachSubmitAction(Request $request, AddCoaches\CommandHandler $addCoachUseCase)
    {
        // We get the data from the form via $request
        $coachName  = $request->get('coachName');
        $salary     = $request->get('salary');
        $clubId     = $request->get('club');

        // We create an array $data just to pass it to our Command
        $data = [
            'coachName' => $coachName,
            'salary'    => $salary,
            'clubId'    => $clubId
        ];

        // We send the data through our Command in order to validate our business logic in the CommandHandler
        $command = new AddCoaches\Command($data);

        // We add a new coach with our useCase and get a Json response
        $response = $addCoachUseCase($command);
        
        // After a coach is added, we redirect to our coach listing
        return $this->redirectToRoute('app_coach');
    }
}
