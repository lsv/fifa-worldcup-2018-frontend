<?php

namespace App\Parser;

use Symfony\Component\HttpFoundation\Request;

class ResultParser
{

    public static function getResult(Request $request, \stdClass $match, $type = 'home'): ?int
    {
        $key = sprintf('m%d%s', $match->name, $type === 'home' ? 'h' : 'a');
        $params = $request->isMethod('POST') ? $request->request : $request->query;
        if ($params->has($key) && $params->get($key) !== '') {
            return (int) $params->get($key);
        }

        return $type === 'home' ? $match->home_result : $match->away_result;
    }

}
