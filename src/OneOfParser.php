<?php

namespace Common\Foundation\RequestSpec;

namespace MPScholten\RequestParser;

/**
 * This class also provides support for Enum values, e.g.:
 *     `$order = SortOrder::fromString($this->bodyParameter('order')->oneOf([SortOrder::ASC(), SortOrder::DESC()])->defaultsTo(SortOrder::ASC());`
 */
class OneOfParser extends AbstractValueParser
{
    private $validValues;

    public function __construct(callable $exceptionFactory, $name, $value, array $validValues)
    {
        $this->validValues = $validValues;
        parent::__construct($exceptionFactory, $name, $value);
    }

    protected function parse($value)
    {
        if (in_array($value, $this->validValues)) {
            return $value;
        } else {
            return null;
        }
    }

    /**
     * @param mixed $defaultValue
     * @return int
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function required()
    {
        return parent::required();
    }
}
