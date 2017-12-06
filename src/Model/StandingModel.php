<?php

namespace App\Model;

class StandingModel
{

    /**
     * @var TeamModel
     */
    private $team;

    /**
     * @var int
     */
    private $played;

    /**
     * @var int
     */
    private $wins;

    /**
     * @var int
     */
    private $draws;

    /**
     * @var int
     */
    private $losts;

    /**
     * @var int
     */
    private $goalsfor;

    /**
     * @var int
     */
    private $goalsagainst;

    public function __construct(TeamModel $team, int $played, int $wins, int $draws, int $losts, int $goalsfor, int $goalsagainst)
    {
        $this->team = $team;
        $this->played = $played;
        $this->wins = $wins;
        $this->draws = $draws;
        $this->losts = $losts;
        $this->goalsfor = $goalsfor;
        $this->goalsagainst = $goalsagainst;
    }

    /**
     * Get Team
     *
     * @return TeamModel
     */
    public function getTeam(): TeamModel
    {
        return $this->team;
    }

    /**
     * Get Played
     *
     * @return int
     */
    public function getPlayed(): int
    {
        return $this->played;
    }


    public function addPlayed(): void
    {
        $this->played++;
    }

    /**
     * Get Wins
     *
     * @return int
     */
    public function getWins(): int
    {
        return $this->wins;
    }

    public function addWin(): void
    {
        $this->wins++;
    }

    /**
     * Get Draws
     *
     * @return int
     */
    public function getDraws(): int
    {
        return $this->draws;
    }

    public function addDraw(): void
    {
        $this->draws++;
    }

    /**
     * Get Losts
     *
     * @return int
     */
    public function getLosts(): int
    {
        return $this->losts;
    }

    public function addLost(): void
    {
        $this->losts++;
    }

    /**
     * Get Goalsfor
     *
     * @return int
     */
    public function getGoalsfor(): int
    {
        return $this->goalsfor;
    }

    public function addGoalsfor(?int $goals): void
    {
        $this->goalsfor += $goals;
    }

    /**
     * Get Goalsagainst
     *
     * @return int
     */
    public function getGoalsagainst(): int
    {
        return $this->goalsagainst;
    }

    public function addGoalsagainst(?int $goals): void
    {
        $this->goalsagainst += $goals;
    }

    /**
     * Get goals difference
     *
     * @return int
     */
    public function getGoalsdifference(): int
    {
        return $this->getGoalsfor() - $this->getGoalsagainst();
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints(): int
    {
        $points = $this->getWins() * 3;
        $points += $this->getDraws();
        return $points;
    }

}
