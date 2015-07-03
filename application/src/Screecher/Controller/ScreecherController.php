<?php
namespace Screecher\Controller;

use Silex\Application;

/**
 * Class ScreecherController
 * @package Screecher\Controller
 */
class ScreecherController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function runAction(Application $app)
    {
        $errors = $app['parser.api_log']->parse();

        if ($errors) {
            $responseData = $app['processor.errors']->processErrors($errors);
        } else {
            $responseData = ['errors' => []];
        }

        return $app['twig']->render('screecherReportPage.html.twig', $responseData);
    }
}