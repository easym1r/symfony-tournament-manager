<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TournamentController extends AbstractController
{
    /**
     * Список всех доступных турниров с возможностью перейти на каждый из этих турниров
     *
     * @param TournamentRepository $tournamentRepository
     *
     * @return Response
     */
    #[Route('/', name: 'tournament_list')]
    public function index(TournamentRepository $tournamentRepository): Response
    {
        $tournaments = $tournamentRepository->findAll();

        return $this->render('tournament/index.html.twig', [
            'title_page' => 'Менеджер турниров. Главная',
            'tournaments' => $tournaments,
        ]);
    }
}
