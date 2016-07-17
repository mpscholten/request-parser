<?php
namespace MPScholten\RequestParser;
class CommaSeparatedParser extends AbstractValueParser
{
    private $dataType;

    const INT = 'INT';
    const STRING = 'STRING';
    const FLOAT = 'FLOAT';
    const BOOLEAN = 'BOOLEAN';
    const YES_NO_BOOLEAN = 'YES_NO_BOOLEAN';
    const JSON = 'JSON';
    const DATE_TIME = 'DATE_TIME';

    /**
     * CommaSeparated constructor.
     * @param callable $exceptionFactory
     * @param string $name
     * @param string $value
     * @param string $type
     */
    public function __construct(callable $exceptionFactory, $name, $value, $type = self::STRING)
    {
        $this->dataType = $type;
        parent::__construct($exceptionFactory, $name, $value);
    }

    /**
     * @param string $value
     * @return int[]|float[]|string[]|boolean[]|\DateTime[]|[]
     */
    protected function parse($value)
    {
        $value = explode(",", $value);
        switch ($this->dataType) {
            case self::INT:
                $value = array_map('intval', $value);
                break;
            case self::STRING:
                // do nothing, already exploded
                break;
            case self::FLOAT:
                $value = array_map('floatval', $value);
                break;
            case self::BOOLEAN:
                $value = array_map(function($element) {
                    if (strtoupper($element) === 'TRUE' || $element === '1') {
                        return true;
                    }
                    if (strtoupper($element) === 'FALSE' || $element === '0') {
                        return false;
                    }
                    return null;
                }, $value);
                break;
            case self::YES_NO_BOOLEAN:
                $value = array_map(function($element) {
                    if (strtoupper($element) === 'YES' || strtoupper($element) === 'Y') {
                        return true;
                    }
                    if (strtoupper($element) === 'NO' || strtoupper($element) === 'N') {
                        return false;
                    }
                    return null;
                }, $value);
                break;
            case self::JSON:
                $value = array_map(function($element) {
                    return json_decode($element, true);
                }, $value);
                break;
            case self::DATE_TIME:
                date_default_timezone_set('UTC');
                $value = array_map(function($element) {
                    if ($element === '') {
                        return null;
                    }
                    try {
                        return new \DateTime($element);
                    } catch (\Exception $e) {
                        return null;
                    }
                }, $value);
                break;
        }
        return $value;
    }

    /**
     * @param int[]|float[]|string[]|boolean[]|\DateTime[]|[] $defaultValue
     * @return int[]|float[]|string[]|boolean[]|\DateTime[]|[]
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    /**
     * @throws \Exception
     * @return boolean
     */
    public function required()
    {
        return parent::required();
    }
}
