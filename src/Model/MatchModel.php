<?php

namespace App\Model;

class MatchModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var TeamModel|string
     */
    private $hometeam;

    /**
     * @var TeamModel|string
     */
    private $awayteam;

    /**
     * @var int|null
     */
    private $homeresult;

    /**
     * @var int|null
     */
    private $awayresult;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var StadiumModel
     */
    private $stadium;

    /**
     * @var array|null
     */
    private $channels;

    /**
     * MatchModel constructor.
     * @param int $id
     * @param TeamModel|string $hometeam
     * @param TeamModel|string $awayteam
     * @param int|null $homeresult
     * @param int|null $awayresult
     * @param \DateTime $date
     * @param StadiumModel $stadium
     * @param ChannelModel[]|null $channels
     */
    public function __construct(int $id, $hometeam, $awayteam, ?int $homeresult, ?int $awayresult, \DateTime $date, StadiumModel $stadium, ?array $channels)
    {
        $this->id = $id;
        $this->hometeam = $hometeam;
        $this->awayteam = $awayteam;
        $this->homeresult = $homeresult;
        $this->awayresult = $awayresult;
        $this->date = $date;
        $this->stadium = $stadium;
        $this->channels = $channels;
    }

    /**
     * Get Id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get Hometeam
     *
     * @return TeamModel|string
     */
    public function getHometeam()
    {
        return $this->hometeam;
    }

    /**
     * Get Awayteam
     *
     * @return TeamModel|string
     */
    public function getAwayteam()
    {
        return $this->awayteam;
    }

    /**
     * Get Homeresult
     *
     * @return int|null
     */
    public function getHomeresult(): ?int
    {
        return $this->homeresult;
    }

    /**
     * Get Awayresult
     *
     * @return int|null
     */
    public function getAwayresult(): ?int
    {
        return $this->awayresult;
    }

    /**
     * Get Date
     *
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * Get Stadium
     *
     * @return StadiumModel
     */
    public function getStadium(): StadiumModel
    {
        return $this->stadium;
    }

    /**
     * Get Channels
     *
     * @return ChannelModel[]|null
     */
    public function getChannels(): ?array
    {
        return $this->channels;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->getHomeresult() !== null && $this->getAwayresult() !== null;
    }

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->getDate() < new \DateTime();
    }

    /**
     * @return mixed TeamModel if the winner is decided, null if the match has not completed, false if its equal
     */
    public function getWinner()
    {
        if (! $this->isFinished()) {
            return null;
        }

        if ($this->getHomeresult() === $this->getAwayresult()) {
            return false;
        }

        return $this->getHomeresult() > $this->getAwayresult() ? $this->getHometeam() : $this->getAwayteam();
    }

    /**
     * @return mixed TeamModel if the loser is decided, null if the match has not completed, false if its equal
     */
    public function getLoser()
    {
        if (! $this->isFinished()) {
            return null;
        }

        if ($this->getHomeresult() === $this->getAwayresult()) {
            return false;
        }

        return $this->getHomeresult() > $this->getAwayresult() ? $this->getAwayteam() : $this->getHometeam();
    }

}
