<?php

namespace App\Model;

class TeamMatch
{

    /**
     * @var MatchModel
     */
    private $match;

    /**
     * @var KnockoutModel|GroupModel
     */
    private $type;

    /**
     * TeamMatch constructor.
     * @param MatchModel $match
     * @param KnockoutModel|GroupModel $type
     */
    public function __construct(MatchModel $match, $type)
    {
        $this->match = $match;
        $this->type = $type;
    }

    /**
     * Get Match
     *
     * @return MatchModel
     */
    public function getMatch(): MatchModel
    {
        return $this->match;
    }

    /**
     * Get Type
     *
     * @return GroupModel|KnockoutModel
     */
    public function getType()
    {
        return $this->type;
    }

}
