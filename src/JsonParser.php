<?php

namespace MPScholten\RequestParser;

class JsonParser extends AbstractValueParser
{
    protected function describe()
    {
        return "a json encoded value";
    }

    protected function parse($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param array $defaultValue
     * @return array
     */
    public function defaultsTo($defaultValue)
    {
        return parent::defaultsTo($defaultValue);
    }

    public function required($invalidValueMessage = null, $notFoundMessage = null)
    {
        return parent::required($invalidValueMessage, $notFoundMessage);
    }

    public function withSchema($jsonSchema)
    {
        $config = new Config();
        $config->setExceptionFactory(new ExceptionFactory(JsonSchemaValidationException::class, JsonSchemaValidationException::class));
        $config->setExceptionMessageFactory(new JsonSchemaValidationExceptionMessageFactory());

        return new SchemaValidationParser($config, $this->name, $this->value, $jsonSchema);
    }
}
