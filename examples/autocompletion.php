<?php

// This example is intended to show of the autocompletion support
// You can try it out by opening this file in PhpStorm and following the steps inside the `autocompletion` method below

require __DIR__ . '/../vendor/autoload.php';

use MPScholten\RequestParser\Symfony\ControllerHelperTrait;

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

class MyController
{
    use ControllerHelperTrait;

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->initRequestParser($request);
    }

    public function autcompletion()
    {
        // Type `$name = $this->queryParameter('name')->` below:
        
        // Now you should see something along the lines of:
        //
        //     $name = $this->queryParameter('name')->
        //                                             dateTime()
        //                                             int()
        //                                             json()
        //                                             oneOf(validValues : array)
        //                                             string()
        // Let's pick `string()` for now
        // So now you should have
        //     $name = $this->queryParameter('name')->string()->
        //
        // Autocompletion pops up again, now you should see something along the lines of:
        //     $name = $this->queryParameter('name')->string()->
        //                                                       required()
        //                                                       defaultsTo(defaultValue : string)
    }
}

$controller = new MyController($request);
$action = $request->get('action');

try {
    echo $controller->$action();
} catch (\MPScholten\RequestParser\NotFoundException $e) {
    echo $e->getMessage();
}
