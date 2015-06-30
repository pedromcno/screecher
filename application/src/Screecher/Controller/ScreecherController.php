<?php
namespace Screecher\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ScreecherController
 * @package Screecher\Controller
 */
class ScreecherController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function runAction(Request $request, Application $app)
    {
        $errors = $app['parser.api_log']->parse();
        if ($errors) {
            $response = $app['processor.errors']->processErrors($errors);
        }

        return $app['twig']->render('screecherReportPage.html.twig', $response);
    }
}