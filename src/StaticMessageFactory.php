<?php

namespace MPScholten\RequestParser;

class StaticMessageFactory implements MessageFactory
{
    /**
     * @var string|null
     */
    private $notFoundMessage;

    /**
     * @var string|null
     */
    private $invalidValueMessage;

    /**
     * @var MessageFactory
     */
    private $fallbackFactory;

    public function __construct($notFoundMessage, $invalidValueMessage, MessageFactory $fallbackFactory)
    {
        $this->notFoundMessage = $notFoundMessage;
        $this->invalidValueMessage = $invalidValueMessage;
        $this->fallbackFactory = $fallbackFactory;
    }

    public function createNotFoundMessage($parameterName)
    {
        if ($this->notFoundMessage === null) {
            return $this->fallbackFactory->createNotFoundMessage($parameterName);
        }

        return $this->notFoundMessage;
    }

    public function createInvalidValueMessage($parameterName, $parameterValue, $expected)
    {
        if ($this->invalidValueMessage === null) {
            return $this->fallbackFactory->createInvalidValueMessage($parameterName, $parameterValue, $expected);
        }

        return $this->invalidValueMessage;
    }
}
