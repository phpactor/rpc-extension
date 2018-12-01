<?php

namespace Phpactor\Extension\Rpc\Registry;

use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\HandlerRegistry;

class ActiveHandlerRegistry implements HandlerRegistry
{
    private $handlers = [];

    public function __construct(array $handlers)
    {
        foreach ($handlers as $handler) {
            $this->register($handler);
        }
    }

    public function get($handlerName): Handler
    {
        if (false === isset($this->handlers[$handlerName])) {
            throw new \InvalidArgumentException(sprintf(
                'No handler "%s", available handlers: "%s"',
                $handlerName,
                implode('", "', array_keys($this->handlers))
            ));
        }

        return $this->handlers[$handlerName];
    }

    private function register(Handler $handler)
    { 
        $name = call_user_func(get_class($handler) .'::name');
        $this->handlers[$name] = $handler;
    }
}
