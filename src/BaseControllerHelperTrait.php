<?php

namespace MPScholten\RequestParser;

trait BaseControllerHelperTrait
{
    /**
     * @var RequestParser
     */
    private $queryParser;

    /**
     * @var RequestParser
     */
    private $bodyParser;

    /**
     * @var RequestParser
     */
    private $cookieParser;

    protected final function initRequestParser($request, $config = null)
    {
        /** @var $requestParserFactory RequestParserFactory */
        $requestParserFactory = $this->createRequestParserFactory($request, $config);
        $this->queryParser = $requestParserFactory->createQueryParser();
        $this->bodyParser = $requestParserFactory->createBodyParser();
        $this->cookieParser = $requestParserFactory->createCookieParser();
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

    /**
     * Use this method to access the request cookie parameters.
     *
     *     $userId = $this->cookieParameter('userId')->int()->defaultsTo(null)
     *
     * @param $name
     * @return TypeParser
     */
    protected function cookieParameter($name)
    {
        return $this->cookieParser->get($name);
    }
}
