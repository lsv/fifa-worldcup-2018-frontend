<?php

namespace App\Controller;

use App\Parser\DataParser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OverviewController
 * @package App\Controller
 *
 * @Route("/{_locale}", defaults={"_locale": null})
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
    public function index(Request $request): Response
    {
        $data = $this->parser->parse($request);
        return $this->render('overview/index.html.twig', [
            'data' => $data,
        ]);
    }
}
