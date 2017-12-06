<?php

namespace App\Model;

class KnockoutModel
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var MatchModel[]
     */
    private $matches;

    public function __construct(string $name, array $matches)
    {
        $this->name = $name;
        $this->matches = $matches;
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

}
