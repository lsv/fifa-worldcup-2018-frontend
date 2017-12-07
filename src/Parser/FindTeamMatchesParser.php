<?php

namespace App\Parser;

use App\Model\AppModel;
use App\Model\TeamMatch;

class FindTeamMatchesParser
{

    /**
     * @param $teamId
     * @param AppModel $model
     * @return TeamMatch[]
     */
    public function parse($teamId, AppModel $model): array
    {
        $matches = [];
        $groups = $model->getGroups();
        foreach ($groups as $group) {
            foreach ($group->getMatches() as $match) {
                if (\is_object($match->getHometeam()) && $match->getHometeam()->getId() === $teamId) {
                    $matches[] = new TeamMatch($match, $group);
                }

                if (\is_object($match->getAwayteam()) && $match->getAwayteam()->getId() === $teamId) {
                    $matches[] = new TeamMatch($match, $group);
                }
            }
        }

        $knockouts = $model->getKnockouts();
        foreach ($knockouts as $knockout) {
            foreach ($knockout->getMatches() as $match) {
                if (\is_object($match->getHometeam()) && $match->getHometeam()->getId() === $teamId) {
                    $matches[] = new TeamMatch($match, $knockout);
                }

                if (\is_object($match->getAwayteam()) && $match->getAwayteam()->getId() === $teamId) {
                    $matches[] = new TeamMatch($match, $knockout);
                }
            }
        }

        return $matches;
    }

}
