<?php

require_once  __DIR__ . '/setup.php';

class Psr7IntegrationTest extends AbstractIntegrationTest
{
    public function controllersProvider()
    {
        $parameters = [
            'string' => 'Test',
            'int' => 1
        ];

        $request = (new Zend\Diactoros\ServerRequest());

        $getRequest = $request
            ->withMethod('GET')
            ->withQueryParams($parameters);

        $postRequest = $request
            ->withMethod('POST')
            ->withParsedBody($parameters);

        return [
            [new Psr7Controller($getRequest)],
            [new Psr7Controller($postRequest)]
        ];
    }
}

class Psr7Controller extends AbstractIntegrationTestController
{
    use \MPScholten\RequestParser\Psr7\ControllerHelperTrait;
}
