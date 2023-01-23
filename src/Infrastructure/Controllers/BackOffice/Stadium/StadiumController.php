<?php

namespace App\Infrastructure\Controllers\BackOffice\Stadium;

use App\Application\Stadium\AddStadium;
use App\Application\Stadium\GetStadiums;
use App\Domain\Exceptions\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class StadiumController extends AbstractController
{

    /**
     * @Route("/admin/stadiums", name="app_admin_stadium")
     * 
     * @param GetStadiums\QueryHandler
     * 
     * @return Response
     */
    public function list(GetStadiums\QueryHandler $useCase): Response
    {
        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        // Get list of Stadiums via useCase where we can show them with the $response->getStadiums()
        $response = $useCase();

        return $this->render('BackOffice/stadium/index.html.twig', [
            'stadiums' => $response->getStadiums()
        ]);
    }

    /**
     * @Route("/addStadium", name="app_admin_add_stadium")
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

        return $this->render('BackOffice/stadium/add--or--update--stadium.html.twig', []);
    }

    /**
     * 
     * @Route("/addStadiumSubmitAction", name="app_admin_add_stadium_submit")
     * 
     * @return Response
     * 
     */
    public function addSubmitAction(Request $request, AddStadium\CommandHandler $useCase): Response
    {
        /** If we are not ROLE_SUPER_ADMIN, we redirect to website clubs */
        try {
            $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'User tried to access admin without having ROLE_SUPER_ADMIN');
        } catch (AccessDeniedException $e) {
            return $this->redirectToRoute('app_website_club');
        }

        $data = (object)[
            'stadiumId'     => (int)$request->get('stadiumId'),
            'stadiumName'   => $request->get('stadiumName'),
            'capacity'      => (int)$request->get('capacity'),
            'built'         => (int)$request->get('built'),
            'address'       => $request->get('address'),
        ];

        $command = new AddStadium\Command($data);

        try {
            $useCase($command);
        } catch (EntityNotFoundException $e) {
            return $e->getMessage();
        }

        return $this->redirectToRoute('app_admin_stadium');
    }
    

}
