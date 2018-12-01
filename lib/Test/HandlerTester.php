<?php

namespace Phpactor\Extension\Rpc\Test;

use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\HandlerRegistry;
use Phpactor\Extension\Rpc\Registry\ActiveHandlerRegistry;
use Phpactor\Extension\Rpc\Request;
use Phpactor\Extension\Rpc\RequestHandler\RequestHandler;

class HandlerTester
{
    const HANDLER_NAME = 'example';

    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(array $parameters)
    {
        $registry = new ActiveHandlerRegistry([
            self::HANDLER_NAME => $this->handler
        ]);
        $requestHandler = new RequestHandler($registry);
        $request = Request::fromNameAndParameters(self::HANDLER_NAME, $parameters);

        return $requestHandler->handle($request);
    }
}
