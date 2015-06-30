<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29/06/15
 * Time: 16:19
 */

namespace Screecher\Controller;

use Screecher\Entity\Maintainer;
use Screecher\Form\Type\MaintainerType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class IndexController
{
    public function indexAction(Request $request, Application $app)
    {
        $apiCollection = $app['repository.api']->findAll();
        return $app['twig']->render('index.html.twig', ['apis' => $apiCollection]);
    }

    public function addMaintainerAction(Request $request, Application $app)
    {
        $maintainer = new Maintainer();

        $apiCollection = $app['repository.api']->findAll();

        /** @var FormInterface $form */
        $form = $app['form.factory']->create(new MaintainerType($apiCollection), $maintainer);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $maintainerData = [
                    'api_id' => $maintainer->getApi(),
                    'email' => $maintainer->getEmail()
                ];

                $subRequest = Request::create(
                    '/api/maintainer',
                    Request::METHOD_POST,
                    array(),
                    array(),
                    array(),
                    array('CONTENT_TYPE' => 'application/json'),
                    json_encode($maintainerData)
                );

                return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST, false);
            }
        }


        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new maintainer',
        );

        return $app['twig']->render('form.html.twig', $data);
    }
}