<?php

namespace App\Model;

class GroupModel
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var StandingModel[]
     */
    private $standings;

    /**
     * @var MatchModel[]
     */
    private $matches;

    /**
     * @var bool
     */
    private $finished;

    /**
     * GroupModel constructor.
     * @param string $name
     * @param StandingModel[] $standings
     * @param MatchModel[] $matches
     * @param bool $finished
     */
    public function __construct(string $name, array $standings, array $matches, $finished = false)
    {
        $this->name = $name;
        $this->matches = $matches;
        $this->standings = $standings;
        $this->finished = $finished;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get Matches
     *
     * @return MatchModel[]
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    /**
     * Get Standings
     *
     * @return StandingModel[]
     */
    public function getStandings(): array
    {
        return $this->standings;
    }

    /**
     * Get Finished
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * Set Finished
     *
     * @param bool $finished
     *
     * @return GroupModel
     */
    public function setFinished(bool $finished): GroupModel
    {
        $this->finished = $finished;
        return $this;
    }

}
