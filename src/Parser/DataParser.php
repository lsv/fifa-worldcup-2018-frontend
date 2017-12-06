<?php

namespace App\Parser;

use App\Model\AppModel;
use Symfony\Component\HttpFoundation\Request;

class DataParser
{

    private const JSON_DATA_URL = 'https://raw.githubusercontent.com/lsv/fifa-worldcup-2018/master/data.json';
    private const JSON_DATA_TESTURL = __DIR__ . '/../../tests/data.json';

    /**
     * @var StadiumParser
     */
    private $stadiumParser;

    /**
     * @var ChannelParser
     */
    private $channelParser;

    /**
     * @var TeamParser
     */
    private $teamParser;

    /**
     * @var GroupParser
     */
    private $groupParser;

    /**
     * @var KnockoutParser
     */
    private $knockoutParser;

    public function __construct(StadiumParser $stadiumParser, ChannelParser $channelParser, TeamParser $teamParser, GroupParser $groupParser, KnockoutParser $knockoutParser)
    {
        $this->stadiumParser = $stadiumParser;
        $this->channelParser = $channelParser;
        $this->teamParser = $teamParser;
        $this->groupParser = $groupParser;
        $this->knockoutParser = $knockoutParser;
    }

    /**
     * @param Request $request
     * @param bool $useTestData
     *
     * @return AppModel
     *
     * @throws \InvalidArgumentException
     */
    public function parse(Request $request, $useTestData = false): AppModel
    {
        $jsonData = file_get_contents($useTestData ? self::JSON_DATA_TESTURL : self::JSON_DATA_URL);
        $json = json_decode($jsonData);
        $this->stadiumParser->parse($json->stadiums);
        $this->channelParser->parse($json->tvchannels);
        $this->teamParser->parse($json->teams);
        $groups = $this->groupParser->parse($json->groups, $request);
        $knockout = $this->knockoutParser->parse($json->knockout, $groups, $request);

        return new AppModel($groups, $knockout);
    }

    /**
     * @param string $date
     *
     * @return \DateTime
     *
     * @throws \InvalidArgumentException
     */
    public static function getDate(string $date): \DateTime
    {
        $dateObject = new \DateTime($date);
        if (! $dateObject) {
            throw new \InvalidArgumentException('Could not parse date "' . $date . '"');
        }
        return $dateObject;
    }

}
