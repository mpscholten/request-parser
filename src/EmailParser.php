<?php

namespace MPScholten\RequestParser;

class EmailParser extends StringParser
{
    protected function parse($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }
        return (string) $value;
    }
}
