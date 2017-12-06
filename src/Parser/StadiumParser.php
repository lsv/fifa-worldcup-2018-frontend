<?php

namespace App\Parser;

use App\Model\StadiumModel;

class StadiumParser
{

    /**
     * @var StadiumModel[]
     */
    static private $stadiums = [];

    /**
     * @param array $stadiums
     */
    public function parse(array $stadiums): void
    {
        foreach ($stadiums as $stadium) {
            self::$stadiums[$stadium->id] = new StadiumModel($stadium->id, $stadium->name);
        }
    }

    /**
     * @param int $stadiumId
     *
     * @return StadiumModel
     *
     * @throws \InvalidArgumentException
     */
    public static function getStadium(int $stadiumId): StadiumModel
    {
        if (isset(self::$stadiums[$stadiumId])) {
            return self::$stadiums[$stadiumId];
        }

        throw new \InvalidArgumentException('Stadium with ID "' . $stadiumId . '" not found');
    }

}
