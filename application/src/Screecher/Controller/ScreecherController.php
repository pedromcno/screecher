<?php
namespace Screecher\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ScreecherController
{
    public function runAction(Request $request, Application $app)
    {
        $responseDataMock = [
            "PineappleAPI" => [
                [
                    "email"  => "pining-for-apples@mailinator.com",
                    "status" => "sent",
                    "_id" => "be08b6c8adfc4706a8c5078d260b8a60",
                    "reject_reason" => NULL
                ]
            ],

            "AppleAPI" => [
                [
                    "email" => "joe.apples@mailinator.com",
                    "status" => "queued",
                    "_id" => "37e5015440074f88a5869a97e723272f",
                ],

                [
                    "email" => "apples-are-great@mailinator.com",
                    "status" => "queued",
                    "_id" => "73cd74d638ca4ff69e8e46b20f0da70e",
                ]
            ]
        ];

        $errorsMock = [
            "PineappleAPI" => [
                "someError1", "someError2", "someError3"
            ],
            "AppleAPI" => ["AppleAPI"]
        ];

        $response = ['emailProviderResponse' => $responseDataMock, 'errors' => $errorsMock];

        $errors = $app['parser.api_log']->parse();
        if ($errors) {
            $response = $app['processor.errors']->processErrors($errors);
        }


        return $app['twig']->render('screecherReportPage.html.twig', $response);
    }
}