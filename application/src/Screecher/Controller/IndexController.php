<?php

namespace Screecher\Controller;

use Screecher\Entity\Maintainer;
use Screecher\Form\Type\MaintainerType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class IndexController
 * @package Screecher\Controller
 */
class IndexController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function indexAction(Application $app)
    {
        $apiCollection = $app['repository.api']->findAll();
        return $app['twig']->render('index.html.twig', ['apis' => $apiCollection]);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function addMaintainerAction(Request $request, Application $app)
    {
        $maintainer = new Maintainer();

        $apiCollection = $app['repository.api']->findAll();

        /** @var FormInterface $form */
        $form = $app['form.factory']->create(new MaintainerType($apiCollection), $maintainer);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $subRequest = $this->createApiMaintainerSubRequest($maintainer);
                return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, false);
            }
        }

        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new maintainer',
        );

        return $app['twig']->render('form.html.twig', $data);
    }


    /**
     * @param Maintainer $maintainer
     * @return Request
     */
    protected function createApiMaintainerSubRequest($maintainer)
    {
        $maintainerData = [
            'api_id' => $maintainer->getApi(),
            'email' => $maintainer->getEmail()
        ];

        return Request::create(
            '/api/maintainer',
            Request::METHOD_POST,
            array(),
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode($maintainerData)
        );
    }
}