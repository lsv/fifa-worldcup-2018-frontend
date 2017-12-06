<?php

namespace App\Parser;

use App\Model\ChannelModel;

class ChannelParser
{

    /**
     * @var ChannelModel[]
     */
    static private $channels;

    /**
     * @param array $channels
     */
    public function parse(array $channels): void
    {
        foreach ($channels as $channel) {
            self::$channels[$channel->id] = new ChannelModel($channel->id, $channel->name, $channel->icon);
        }
    }

    /**
     * @param int[] $channels
     *
     * @return ChannelModel[]
     *
     * @throws \InvalidArgumentException
     */
    public static function getChannels(array $channels): array
    {
        $output = [];
        foreach ($channels as $channel) {
            if (! isset(self::$channels[$channel])) {
                throw new \InvalidArgumentException('Channel with ID "' . $channel . '" not found');
            }
            $output[] = self::$channels[$channel];
        }

        return $output;
    }

}
