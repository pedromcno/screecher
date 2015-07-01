<?php

namespace Screecher\Tests\Controllers;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiApiControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();

        $dbName = $this->app['db.options']['dbname'];
        $dbUser = $this->app['db.options']['user'];
        shell_exec(sprintf('mysql -u%s -e "drop database if exists %s"', $dbUser, $dbName));
        shell_exec(sprintf('mysqladmin -u%s create %s', $dbUser, $dbName));
        shell_exec(sprintf('mysql -u%s %s < %s', $dbUser, $dbName, __DIR__ . '/../../../../app/db_dump.sql'));

        $this->client = $this->createClient();
    }

    public function createApplication()
    {
        $app_env = 'test';
        $app = require __DIR__ . '/../../../../public/index.php';
        return $app;
    }

    public function testApiApiSuccess()
    {
        $this->client->request(
            'GET',
            '/api/api/1'
        );

        $this->assertEquals($this->client->getResponse()->getStatusCode(), Response::HTTP_OK);
    }

    public function testApiApiWrongId()
    {
        $this->client->request(
            'GET',
            '/api/api/999888777666555444'
        );

        $this->assertEquals($this->client->getResponse()->getStatusCode(), Response::HTTP_NOT_FOUND);
    }

    public function testAddMaintainerSuccess()
    {
        $this->client->request(
            'POST',
            '/api/maintainer',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"api_id":"1", "email":"test@mailinator.com"}'
        );

        $this->assertEquals($this->client->getResponse()->getStatusCode(), Response::HTTP_CREATED);
        $json = $this->client->getResponse()->getContent();
        $dataObject = json_decode($json);
        $this->assertAttributeNotEmpty('id', $dataObject);
    }

    public function testAddMaintainerWithInvalidData()
    {
        $this->client->request(
            'POST',
            '/api/maintainer',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"wrongParameter":"1", "email":"test@mailinator.com"}'
        );

        $this->assertEquals($this->client->getResponse()->getStatusCode(), Response::HTTP_BAD_REQUEST);
    }
}