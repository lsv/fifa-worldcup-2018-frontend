<?php

namespace App\Parser;

use App\Model\GroupModel;
use App\Model\KnockoutModel;
use App\Model\MatchModel;
use App\Model\TeamModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class KnockoutParser
{

    /**
     * @var MatchModel[]
     */
    private $knouckoutMatches = [];

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param \stdClass $phases
     * @param GroupModel[] $groups
     * @param Request $request
     *
     * @return KnockoutModel[]
     *
     * @throws \InvalidArgumentException
     */
    public function parse(\stdClass $phases, array $groups, Request $request): array
    {
        $phasesArray = get_object_vars($phases);
        $output = [];
        $this->knouckoutMatches = [];
        foreach ($phasesArray as $round => $knockout) {
            $output[$round] = new KnockoutModel(
                $knockout->name,
                $this->createKnockoutMatches($knockout->matches, $groups, $request)
            );
        }
        return $output;
    }

    /**
     * @param array $matches
     * @param GroupModel[] $groups
     * @param Request $request
     *
     * @return MatchModel[]
     *
     * @throws \InvalidArgumentException
     */
    private function createKnockoutMatches(array $matches, array $groups, Request $request) : array
    {
        $output = [];
        foreach ($matches as $match) {
            $data = new MatchModel(
                $match->name,
                $this->getKnockoutTeam($match->type, $match->home_team, $groups),
                $this->getKnockoutTeam($match->type, $match->away_team, $groups),
                ResultParser::getResult($request, $match),
                ResultParser::getResult($request, $match, 'away'),
                DataParser::getDate($match->date),
                StadiumParser::getStadium($match->stadium),
                ChannelParser::getChannels($match->channels)
            );
            $this->knouckoutMatches[$match->name] = $data;
            $output[] = $data;
        }

        return $output;
    }

    /**
     * @param string $matchType
     * @param string $matchTeam
     * @param GroupModel[] $groups
     *
     * @return string|TeamModel
     *
     * @throws \Symfony\Component\Translation\Exception\InvalidArgumentException
     */
    private function getKnockoutTeam($matchType, $matchTeam, array $groups)
    {
        switch ($matchType) {
            default:
            case 'qualified':
                [$type, $group] = explode('_', $matchTeam);
                if ($type === 'winner') {
                    return $groups[$group]->isFinished()
                        ? $groups[$group]->getStandings()[0]->getTeam()
                        : $this->translator->trans('Winner of group %group%', ['%group%' => strtoupper($group)])
                    ;
                }

                return $groups[$group]->isFinished()
                    ? $groups[$group]->getStandings()[1]->getTeam()
                    : $this->translator->trans('Runner up group %group%', ['%group%' => strtoupper($group)])
                ;
            case 'winner':
                if (! $winner = $this->knouckoutMatches[$matchTeam]->getWinner()) {
                    return $this->translator->trans('Winner of match %match%', ['%match%' => $matchTeam]);
                }
                return $winner;
            case 'loser':
                if (! $loser = $this->knouckoutMatches[$matchTeam]->getLoser()) {
                    return $this->translator->trans('Loser of match %match%', ['%match%' => $matchTeam]);
                }
                return $loser;
        }
    }

}
