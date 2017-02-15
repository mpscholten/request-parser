<?php

namespace MPScholten\RequestParser;

class TrimParser extends AbstractValueParser
{
    private $trimType;

    public function __construct(Config $config, $name, $value, $trimType)
    {
        $this->trimType = $trimType;
        parent::__construct($config, $name, $value);
    }

    protected function describe()
    {
        return "a text string";
    }

    protected function parse($value)
    {
        if ($this->trimType === TrimType::TRIM) {
            return trim((string) $value);
        } elseif ($this->trimType === TrimType::LEFT_TRIM) {
            return ltrim((string) $value);
        } elseif ($this->trimType === TrimType::RIGHT_TRIM) {
            return rtrim((string) $value);
        }
        return (string) $value;
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return string
     */
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param string $defaultValue
     * @return string
     */
    public function defaultsToIfEmpty($defaultValue)
    {
        if ($this->value === '') {
            return $defaultValue;
        }

        return $this->defaultsTo($defaultValue);
    }
}
