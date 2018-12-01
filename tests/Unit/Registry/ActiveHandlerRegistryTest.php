<?php

namespace Phpactor\Extension\Rpc\Tests\Unit\Registry;

use PHPUnit\Framework\TestCase;

use Phpactor\Extension\Rpc\HandlerRegistry;
use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\Registry\ActiveHandlerRegistry;

class ActiveHandlerRegistryTest extends TestCase
{
    public function testExceptionForUnkown()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No handler "aaa"');

        $action = $this->prophesize(Handler::class);
        $registry = $this->create([ 'one' => $action->reveal() ]);

        $registry->get('aaa');
    }

    public function testGetAction()
    {
        $action = $this->prophesize(Handler::class);
        $registry = $this->create([ 'one' => $action->reveal() ]);

        $this->assertSame($action->reveal(), $registry->get('one'));
    }

    public function create(array $actions = [])
    {
        return new ActiveHandlerRegistry($actions);
    }
}
