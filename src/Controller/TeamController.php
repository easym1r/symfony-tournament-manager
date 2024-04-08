<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/teams', name: 'team_list', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'title_page' => 'Менеджер турниров. Команды',
            'teams' => $teams,
        ]);
    }

    /**
     * Удаление записи о команде
     *
     * @param Team $team
     * @param TeamRepository $teamRepository
     *
     * @return Response
     */
    #[Route('/teams/delete/{id}', name: 'team_delete', methods: ['GET'])]
    public function delete(Team $team, TeamRepository $teamRepository): Response
    {
        try {
            $teamRepository->delete($team);

            return $this->redirectToRoute('team_list');
        } catch (\Throwable $exception) { // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'При удаление команда возникла ошибка: ' . $exception->getMessage() . '. Свяжитесь с администратором!';

            return $this->redirectToRoute('team_list');
        }
    }

    #[Route('/teams/registration', name: 'team_registration', methods: ['POST'])]
    public function add(Request $request, TeamRepository $teamRepository): Response
    {
        $teamName = $request->request->get('teamName');

        if (empty($teamName)) {
            // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'Ошибка! Необходимо указать название команды, которую вы пытаетесь зарегистрировать!';

            return $this->redirectToRoute('team_list');
        }

        try {
            $teamRepository->add($teamName);

            return $this->redirectToRoute('team_list');
        } catch (\Throwable $exception) { // TODO Добавить логирование прочих ошибок в БД + их вывод пользователю
            $stubMsg = 'При добавление команда возникла ошибка: ' . $exception->getMessage() . '. Свяжитесь с администратором!';

            return $this->redirectToRoute('tournament_list');
        }
    }
}
