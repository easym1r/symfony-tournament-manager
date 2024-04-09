<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Repository\TeamRepository;
use App\Repository\TournamentRepository;
use App\Repository\TournamentTeamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TournamentController extends AbstractController
{
    /**
     * Список всех доступных турниров с возможностью перейти на каждый из этих турниров
     *
     * @param TournamentRepository $tournamentRepository
     * @param TeamRepository $teamRepository
     *
     * @return Response
     */
    #[Route('/', name: 'tournament_list', methods: ['GET'])]
    public function index(TournamentRepository $tournamentRepository, TeamRepository $teamRepository): Response
    {
        $tournaments = $tournamentRepository->findAll();
        $teams = $teamRepository->findAll();

        return $this->render('tournament/index.html.twig', [
            'title_page' => 'Менеджер турниров. Главная',
            'tournaments' => $tournaments,
            'teams' => $teams,
        ]);
    }

    /**
     * Добавление записи о турнире + записи об привязки команд к турниру (таблица tournament_teams)
     *
     * @param Request $request
     * @param TeamRepository $teamRepository
     * @param TournamentRepository $tournamentRepository
     * @param TournamentTeamsRepository $tournamentTeamsRepository
     *
     * @return Response
     */
    #[Route('/tournaments/registration', name: 'tournament_registration', methods: ['POST'])]
    public function add(Request                   $request,
                        TournamentRepository      $tournamentRepository,
                        TeamRepository            $teamRepository,
                        TournamentTeamsRepository $tournamentTeamsRepository): Response
    {
        $tournamentName = $request->request->get('tournamentName');
        $selectedTeams = $request->request->all('selectedTeams');

        if (empty($tournamentName)) {
            // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'Ошибка! Необходимо указать название турнира, который вы пытаетесь зарегистрировать!';

            return $this->redirectToRoute('tournament_list');
        }

        try {
            $tournamentId = $tournamentRepository->add($tournamentName);

            // По умолчанию ВСЕ команды автоматом попадают в турнир
            if (empty($selectedTeams)) {
                $teams = $teamRepository->findAll();

                foreach ($teams as $team) {
                    $selectedTeams[] = $team->getId();
                }
            }

            $tournamentTeamsRepository->add($tournamentId, $selectedTeams);

            return $this->redirectToRoute('tournament_list');
        } catch (\Throwable $exception) { // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'При добавление команда возникла ошибка: ' . $exception->getMessage() . '. Свяжитесь с администратором!';

            return $this->redirectToRoute('tournament_list');
        }
    }

    /**
     * Удаление записи о турнире
     *
     * @param Tournament $tournament
     * @param TournamentRepository $tournamentRepository
     *
     * @return Response
     */
    #[Route('/tournaments/delete/{id}', name: 'tournament_delete', methods: ['GET'])]
    public function delete(Tournament $tournament, TournamentRepository $tournamentRepository): Response
    {
        try {
            $tournamentRepository->delete($tournament);

            return $this->redirectToRoute('tournament_list');
        } catch (\Throwable $exception) { // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'При удаление команда возникла ошибка: ' . $exception->getMessage() . '. Свяжитесь с администратором!';

            return $this->redirectToRoute('tournament_list');
        }
    }

    #[Route('/tournaments/{name}', name: 'tournament_detail', methods: ['GET'])]
    public function detail(Tournament $tournament, TeamRepository $teamRepository, TournamentTeamsRepository $tournamentTeamsRepository): Response
    {
        $teamsIds = $tournamentTeamsRepository->findTeamsByTournamentId($tournament->getId());

        $teams = [];
        if (!empty($teamsIds)) {
            $teams = $teamRepository->findById($teamsIds);

            unset($teamsIds);
        }

        return $this->render('tournament/detail.html.twig', [
            'title_page' => 'Менеджер турниров. Турнир',
            'tournament' => $tournament,
            'teams' => $teams,
        ]);
    }

    #[Route('/tournaments/{name}', name: 'tournament_grid_generation', methods: ['POST'])]
    public function gridGeneration(Tournament $tournament, TeamRepository $teamRepository, TournamentTeamsRepository $tournamentTeamsRepository)
    {
        $grid = [];
        $teams = [];

        $teamsIds = $tournamentTeamsRepository->findTeamsByTournamentId($tournament->getId());

        if (!empty($teamsIds)) {
            $teamsInfo = $teamRepository->findById($teamsIds);

            unset($teamsIds);
        }

        foreach ($teamsInfo as $team) {
            $teams[] = $team->getName();
        }

        // TODO временно вместо генерации турнирной сетки, генерация всех возможных комбинаций команд.
        // TODO алгоритм по построению плотной по дням турнирной сетки в разработке
        // FIXME готовое решение необходимо вынести в отдельную модель
        $countTeams = count($teams);

        for ($i = 0; $i < $countTeams - 1; $i++) {
            for ($j = $i + 1; $j < $countTeams; $j++) {
                $pairs[] = [$teams[$i], $teams[$j]];
            }
        }

        return dd($pairs);
    }
}
