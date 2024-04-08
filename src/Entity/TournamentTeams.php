<?php

namespace App\Entity;

use App\Repository\TournamentTeamsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: "tournament_teams")]
#[ORM\Entity(repositoryClass: TournamentTeamsRepository::class)]
class TournamentTeams
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $tournament_id = null;

    #[ORM\Id]
    #[ORM\Column]
    private ?int $team_id = null;

    public function getTournamentId(): ?int
    {
        return $this->tournament_id;
    }

    public function setTournamentId(int $tournament_id): static
    {
        $this->tournament_id = $tournament_id;

        return $this;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function setTeamId(int $team_id): static
    {
        $this->team_id = $team_id;

        return $this;
    }
}
