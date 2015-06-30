<?php

namespace Screecher\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Screecher\Entity\Api;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiApiController
 * @package Screecher\Controller
 */
class ApiApiController
{
    use ResponseErrorFormatTrait;

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function viewAction(Request $request, Application $app)
    {
        $api = $request->attributes->get('apiId');

        if (!$api) {
            return $app->json($this->formatError(Response::HTTP_NOT_FOUND, 'The requested api was not found.'),
                Response::HTTP_NOT_FOUND);
        }

        $maintainersCollection = $app['repository.maintainer']->findAllByApi($api->getId());

        $dataApi = [
            'id' => $api->getId(),
            'name' => $api->getName(),
            'maintainers' => $maintainersCollection
        ];

        return $app->json($dataApi, Response::HTTP_OK);
    }


    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addMaintainerAction(Request $request, Application $app)
    {
        $maintainerData = json_decode($request->getContent(), true);

        try {
            $result = $app['repository.maintainer']->save($maintainerData);
        } catch (UniqueConstraintViolationException $e) {
            return $app->json($this->formatError(Response::HTTP_BAD_REQUEST, 'Maintainer already exist'),
                Response::HTTP_BAD_REQUEST);
        } catch (InvalidFieldNameException $e) {
            return $app->json($this->formatError(Response::HTTP_BAD_REQUEST, 'Some parameters are wrong or missing'),
                Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return $app->json($this->formatError(Response::HTTP_BAD_REQUEST, 'Bad request'),
                Response::HTTP_BAD_REQUEST);
        }

        return $app->json($result, Response::HTTP_CREATED);
    }
}