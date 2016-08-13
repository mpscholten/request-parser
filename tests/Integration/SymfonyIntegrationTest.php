<?php

require_once  __DIR__ . '/setup.php';

class SymfonyIntegrationTest extends AbstractIntegrationTest
{
    public function controllersProvider()
    {
        $parameters = [
            'string' => 'Test',
            'int' => 1
        ];

        $getRequest = new \Symfony\Component\HttpFoundation\Request($parameters);
        $getRequest->setMethod('GET');

        $postRequest = new \Symfony\Component\HttpFoundation\Request([], $parameters);
        $postRequest->setMethod('POST');

        return [
            [new SymfonyController($getRequest)],
            [new SymfonyController($postRequest)]
        ];
    }
}

class SymfonyController extends AbstractIntegrationTestController
{
    use \MPScholten\RequestParser\Symfony\ControllerHelperTrait;
}
