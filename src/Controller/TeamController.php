<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamController extends AbstractController
{
    /**
     * Список всех зарегистрированных в системе команд
     *
     * @param TeamRepository $teamRepository
     *
     * @return Response
     */
    #[Route('/teams', name: 'team_list')]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'title_page' => 'Менеджер турниров. Команды',
            'teams' => $teams,
        ]);
    }
}
