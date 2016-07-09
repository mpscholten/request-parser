<?php

namespace MPScholten\RequestParser;

class CommaSeparatedParser extends AbstractValueParser
{
    const INT = 'INT';
    const STRING = 'STRING';
    const FLOAT = 'FLOAT';
    const BOOLEAN = 'BOOLEAN';
    const YES_NO_BOOLEAN = 'YES_NO_BOOLEAN';
    const JSON = 'JSON';
    const DATE_TIME = 'DATE_TIME';

    private $type;

    protected function parse($value)
    {
        if (!isset($this->type)) {
            $this->type = self::STRING;
        }
        $valuesArray = explode(",", $value);
        switch ($this->type) {
            case self::INT:
                $valuesArray = array_map('intval', $valuesArray);
                break;
            case self::STRING:
                // do nothing, already exploded
                break;
            case self::FLOAT:
                $valuesArray = array_map('floatval', $valuesArray);
                break;
            case self::BOOLEAN:
                $valuesArray = array_map(function($element) {
                    if (strtoupper($element) === 'TRUE' || $element === '1') {
                        return true;
                    }
                    if (strtoupper($element) === 'FALSE' || $element === '0') {
                        return false;
                    }
                    return null;
                }, $valuesArray);
                break;
            case self::YES_NO_BOOLEAN:
                $valuesArray = array_map(function($element) {
                    if (strtoupper($element) === 'YES' || strtoupper($element) === 'Y') {
                        return true;
                    }
                    if (strtoupper($element) === 'NO' || strtoupper($element) === 'N') {
                        return false;
                    }
                    return null;
                }, $valuesArray);
                break;
            case self::JSON:
                $valuesArray = array_map(function($element) {
                    return json_decode($element, true);
                }, $valuesArray);
                break;
            case self::DATE_TIME:
                $valuesArray = array_map(function($element) {
                    if ($element === '') {
                        return null;
                    }
                    try {
                        return new \DateTime($element);
                    } catch (\Exception $e) {
                        return null;
                    }
                }, $valuesArray);
                break;
        }
        return $valuesArray;
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
        return $this;
    }

    public function int()
    {
        $this->type = self::INT;
        return $this;
    }

    public function string()
    {
        $this->type = self::STRING;
        return $this;
    }

    public function float()
    {
        $this->type = self::FLOAT;
        return $this;
    }

    public function boolean()
    {
        $this->type = self::BOOLEAN;
        return $this;
    }

    public function yesNoBoolean()
    {
        $this->type = self::YES_NO_BOOLEAN;
        return $this;
    }

    public function json()
    {
        $this->type = self::JSON;
        return $this;
    }

    public function dateTime()
    {
        $this->type = self::DATE_TIME;
        return $this;
    }
}
