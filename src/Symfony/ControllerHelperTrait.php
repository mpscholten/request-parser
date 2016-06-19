<?php

namespace MPScholten\RequestParser\Symfony;

use MPScholten\RequestParser\RequestParser;
use MPScholten\RequestParser\TypeParser;
use Symfony\Component\HttpFoundation\Request;

trait ControllerHelperTrait
{
    /**
     * @var RequestParser
     */
    private $queryParser;

    /**
     * @var RequestParser
     */
    private $bodyParser;

    protected final function initRequestParser(Request $request, callable $exceptionFactory = null)
    {
        $requestParser = new SymfonyRequestParser($request, $exceptionFactory);
        $this->queryParser = $requestParser->createQueryParser();
        $this->bodyParser = $requestParser->createBodyParser();
    }

    /**
     * Use this method to access the query parameters of the request.
     *
     *     $page = $this->queryParameter('page')->int()->defaultsTo(0)
     *
     * @param string $name
     * @return TypeParser
     */
    protected function queryParameter($name)
    {
        return $this->queryParser->get($name);
    }

    /**
     * Use this method to access the body parameters of the request (e.g. $_POST).
     *
     *     $password = $this->bodyParameter('password')->string()->required()
     *
     * @param string $name
     * @return TypeParser
     */
    protected function bodyParameter($name)
    {
        return $this->bodyParser->get($name);
    }
}
