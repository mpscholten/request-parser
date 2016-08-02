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

            trigger_error($this->generateCallbackBasedExceptionHandlingDeprecatedMessage($exceptionFactory), E_USER_DEPRECATED);
        }

        $this->readParameter = $readParameter;
        $this->config = $config;
    }

    private function generateCallbackBasedExceptionHandlingDeprecatedMessage(callable $callback)
    {
        $testException = $callback('$parameterName');

        $exceptionClass = get_class($testException);
        $exceptionMessage = $testException->getMessage();

        $callbackCode = "function (\$parameterName) { return new $exceptionClass(\"...\"); }";

        $message = "RequestParser: Callback based Exception configuration is deprecated. ";
        $message .= "To get get better error messages for invalid parameters (e.g. a string is provided to a `->int()->required()`) ";
        $message .= "you just need to migrate your code (more infos: http://bit.ly/2aGyX99).\n\n";

        $message .= "Your current error callback (`$callbackCode`) should be replaced with something along of:\n";
        $message .= "class CustomExceptionMessageFactory extends \\MPScholten\\RequestParser\\ExceptionMessageFactory {\n";
        $message .= "    protected function createNotFoundMessage(\$parameterName) { return \"$exceptionMessage\"; }\n";
        $message .= "}\n";
        $message .= "\n";
        $message .= "// In your controller:\n";
        $message .= "\$config = new \\MPScholten\\RequestParser\\Config();\n";
        $message .= "\$config->setExceptionFactory(new CustomExceptionMessageFactory());\n";
        $message .= "\$this->initRequestParser(\$request, \$config);\n";

        return $message;
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
