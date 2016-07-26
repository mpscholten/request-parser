<?php

namespace MPScholten\RequestParser;

class UrlParser extends StringParser
{
    protected function parse($value)
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return null;
        }
        return (string) $value;
    }
}
