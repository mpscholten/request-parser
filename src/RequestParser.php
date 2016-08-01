<?php

namespace MPScholten\RequestParser;

class RequestParser
{
    /**
     * @var callable
     */
    private $readParameter;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param callable $readParameter
     * @param Config|callable $config
     */
    public function __construct(callable $readParameter, $config)
    {
        if ($config === null) {
            $config = new Config();
        } elseif (is_callable($config)) {
            // Support for legacy config
            $exceptionFactory = $config;
            $config = new Config();
            $config->setExceptionMessageFactory(new LegacyExceptionMessageFactory());
            $config->setExceptionFactory(new LegacyExceptionFactory($exceptionFactory));
        }

        $this->readParameter = $readParameter;
        $this->config = $config;
    }

    protected final function readValue($name)
    {
        return call_user_func($this->readParameter, $name);
    }

    public function get($name)
    {
        return new TypeParser($this->config, $name, $this->readValue($name));
    }
}
