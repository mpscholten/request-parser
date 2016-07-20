<?php

namespace MPScholten\RequestParser;

/**
 * Class CommaSeparatedJsonParser
 * @package MPScholten\RequestParser
 *
 * The following input strings are both valid for this parser:
 *
 *      1. Plain JSON objects, comma separated, à la:
 *         {"a": 0, "b": 1}, {"c": 2, "d": 3}
 *      2. JSON arrays, à la:
 *         [{"a": 0, "b": 1}, {"c": 2, "d": 3}]
 */
class CommaSeparatedJsonParser extends AbstractValueParser
{
    protected function parse($value)
    {
        if (!empty($value) && $value[0] !== '[' && $value[strlen($value) - 1] !== ']') {
            $value = '[' . $value . ']';
        }
        try {
            $value = json_decode($value, true);
            return $value;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param array $defaultValue
     * @return array
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function required()
    {
        return parent::required();
    }
}
