<?php

namespace Phpactor\Extension\Rpc\Test;

use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\HandlerRegistry;
use Phpactor\Extension\Rpc\Request;
use Phpactor\Extension\Rpc\RequestHandler\RequestHandler;

class HandlerTester
{
    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(string $actionName, array $parameters)
    {
        $registry = new HandlerRegistry([
            $this->handler
        ]);
        $requestHandler = new RequestHandler($registry);
        $request = Request::fromNameAndParameters($actionName, $parameters);

        return $requestHandler->handle($request);
    }
}
