<?php

namespace MPScholten\RequestParser;

use JsonSchema\Validator;
use JsonSchema\RefResolver;
use JsonSchema\Uri\UriRetriever;
use JsonSchema\Uri\UriResolver;

class SchemaValidationParser extends AbstractValueParser
{
    private $jsonSchema;
    private $isRemote;

    public function __construct(Config $config, $name, $value, $jsonSchema, $isRemote)
    {
        $this->jsonSchema = $jsonSchema;
        $this->isRemote = $isRemote;
        parent::__construct($config, $name, $value);
    }

    protected function describe()
    {
        return "a valid JSON encoded value that conforms with a given schema";
    }

    protected function parse($value)
    {
        $inspectedValue = (object) $value;
        $refResolver = new RefResolver(new UriRetriever(), new UriResolver());

        if ($this->isRemote) {
            $jsonSchema = $refResolver->resolve($this->jsonSchema);
        } else {
            $jsonSchema = json_decode($this->jsonSchema);
        }

        $validator = new Validator();

        $validator->check($inspectedValue, $jsonSchema);
        if ($validator->isValid()) {
            return $value;
        }
        return null;
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
    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    /**
     * @param array $defaultValue
     * @return array
     */
    public function defaultsToIfEmpty($defaultValue)
    {
        if ($this->value === '') {
            return $defaultValue;
        }

        return $this->defaultsTo($defaultValue);
    }
}
