<?php

namespace MPScholten\RequestParser;

interface RequestParserFactory
{
    /**
     * @return RequestParser
     */
    public function createQueryParser();

    /**
     * @return RequestParser
     */
    public function createBodyParser();

    /**
     * @return RequestParser
     */
    public function createCookieParser();
}
