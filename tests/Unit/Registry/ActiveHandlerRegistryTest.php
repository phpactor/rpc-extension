<?php

namespace Phpactor\Extension\Rpc\Tests\Unit\Registry;

use PHPUnit\Framework\TestCase;

use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor\Extension\Rpc\Registry\ActiveHandlerRegistry;

class ActiveHandlerRegistryTest extends TestCase
{
    public function testExceptionForUnkown()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No handler "aaa"');

        $action = new EchoHandler();
        $registry = $this->create([ $action ]);

        $registry->get('aaa');
    }

    public function testGetAction()
    {
        $action = new EchoHandler();
        $registry = $this->create([ $action ]);

        $this->assertSame($action, $registry->get('echo'));
    }

    public function create(array $actions = [])
    {
        return new ActiveHandlerRegistry($actions);
    }
}
