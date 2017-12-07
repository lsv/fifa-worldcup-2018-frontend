<?php

namespace App\Controller;

use App\Parser\DataParser;
use App\Parser\FindTeamMatchesParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OverviewController
 * @package App\Controller
 *
 * @Route("/")
 */
class OverviewController extends Controller
{

    /**
     * @var DataParser
     */
    private $parser;

    public function __construct(DataParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @Route(name="overview_index")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function indexAction(Request $request): Response
    {
        $data = $this->parser->parse($request);
        return $this->render('overview/index.html.twig', [
            'data' => $data,
        ]);
    }

    /**
     * @Route("/{team}", name="overview_team")
     *
     * @param FindTeamMatchesParser $matchesParser
     * @param Request $request
     * @param $team
     *
     * @return Response
     *
     * @throws \InvalidArgumentException
     */
    public function teamAction(FindTeamMatchesParser $matchesParser, Request $request, $team): Response
    {
        $data = $this->parser->parse($request);
        $teamMatches = $matchesParser->parse((int)$team, $data);
        $view = $this->renderView('overview/team.html.twig', [
            'data' => $teamMatches,
        ]);
        return new JsonResponse($view);
    }
}
