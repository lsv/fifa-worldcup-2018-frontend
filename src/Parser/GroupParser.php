<?php

namespace App\Parser;

use App\Model\GroupModel;
use App\Model\MatchModel;
use App\Model\StandingModel;
use Symfony\Component\HttpFoundation\Request;

class GroupParser
{

    /**
     * @param \stdClass $groups
     *
     * @param Request $request
     *
     * @return GroupModel[]
     *
     * @throws \InvalidArgumentException
     */
    public function parse(\stdClass $groups, Request $request): array
    {
        $groupArray = get_object_vars($groups);
        $models = [];
        foreach ($groupArray as $key => $group) {
            $finished = true;
            $matches = $this->createMatches($request, $group->matches, $finished);
            $models[$key] = new GroupModel($key, $this->createStandings($matches), $matches, $finished);
        }

        return $models;
    }

    /**
     * @param Request $request
     * @param array $data
     * @param bool $finished
     *
     * @return MatchModel[]
     *
     * @throws \InvalidArgumentException
     */
    private function createMatches(Request $request, array $data, bool &$finished) : array
    {
        $matches = [];
        foreach ($data as $match) {
            $object = new MatchModel(
                $match->name,
                TeamParser::getTeam($match->home_team),
                TeamParser::getTeam($match->away_team),
                ResultParser::getResult($request, $match),
                ResultParser::getResult($request, $match, 'away'),
                DataParser::getDate($match->date),
                StadiumParser::getStadium($match->stadium),
                ChannelParser::getChannels($match->channels)
            );

            if ($object->getHomeresult() === null || $object->getAwayresult() === null) {
                $finished = false;
            }

            $matches[] = $object;
        }
        return $matches;
    }

    /**
     * @param MatchModel[] $matches
     *
     * @return StandingModel[]
     */
    private function createStandings(array $matches) : array
    {
        $standings = [];
        foreach ($matches as $match) {
            $this->parseStandingMatch($standings, $match);
            $this->parseStandingMatch($standings, $match, false);
        }

        usort($standings, function(StandingModel $a, StandingModel $b) use ($matches) {
            if ($a->getPoints() !== $b->getPoints()) {
                return $a->getPoints() < $b->getPoints();
            }

            if ($a->getGoalsdifference() !== $b->getGoalsdifference()) {
                return $a->getGoalsdifference() < $b->getGoalsdifference();
            }

            foreach ($matches as $match) {
                if ($match->getHometeam()->getId() === $a->getTeam()->getId() && $match->getAwayteam()->getId() === $b->getTeam()->getId()) {
                    if ($match->getHomeresult() > $match->getAwayresult()) {
                        return -1;
                    }

                    if ($match->getAwayresult() > $match->getHomeresult()) {
                        return 1;
                    }
                }

                if ($match->getHometeam()->getId() === $b->getTeam()->getId() && $match->getAwayteam()->getId() === $a->getTeam()->getId()) {
                    if ($match->getHomeresult() > $match->getAwayresult()) {
                        return 1;
                    }

                    if ($match->getAwayresult() > $match->getHomeresult()) {
                        return -1;
                    }
                }
            }

            return $a->getTeam()->getId() <=> $b->getTeam()->getId();
        });

        return $standings;
    }

    /**
     * @param StandingModel[] $standings
     * @param MatchModel $match
     * @param bool $parseHometeam
     */
    private function parseStandingMatch(array &$standings, MatchModel $match, $parseHometeam = true): void
    {
        $team = $parseHometeam ? $match->getHometeam() : $match->getAwayteam();
        if (! isset($standings[$team->getId()])) {
            $standings[$team->getId()] = new StandingModel(
                $team,
                0,
                0,
                0,
                0,
                0,
                0
            );
        }

        /** @var StandingModel $stand */
        $stand = $standings[$team->getId()];
        if ($match->isFinished()) {
            $stand->addPlayed();
            if ($parseHometeam) {
                $stand->addGoalsfor($match->getHomeresult());
                $stand->addGoalsagainst($match->getAwayresult());
            } else {
                $stand->addGoalsfor($match->getAwayresult());
                $stand->addGoalsagainst($match->getHomeresult());
            }

            if ($parseHometeam) {
                if ($match->getHomeresult() > $match->getAwayresult()) {
                    $stand->addWin();
                } elseif ($match->getHomeresult() === $match->getAwayresult()) {
                    $stand->addDraw();
                } else {
                    $stand->addLost();
                }
            } else {
                if ($match->getAwayresult() > $match->getHomeresult()) {
                    $stand->addWin();
                } elseif ($match->getAwayresult() === $match->getHomeresult()) {
                    $stand->addDraw();
                } else {
                    $stand->addLost();
                }
            }
        }
    }

}
