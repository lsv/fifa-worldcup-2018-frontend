<?php

namespace App\Parser;

use App\Model\TeamModel;

class TeamParser
{

    /**
     * @var TeamModel[]
     */
    static private $teams;

    /**
     * @param array $teams
     */
    public function parse(array $teams): void
    {
        foreach ($teams as $team) {
            self::$teams[$team->id] = new TeamModel($team->id, $team->name, $team->iso2);
        }
    }

    /**
     * @param int $teamId
     *
     * @return TeamModel
     *
     * @throws \InvalidArgumentException
     */
    public static function getTeam(int $teamId): TeamModel
    {
        if (isset(self::$teams[$teamId])) {
            return self::$teams[$teamId];
        }

        throw new \InvalidArgumentException('Team with ID "' . $teamId . '" not found');
    }

}
