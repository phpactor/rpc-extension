<?php

namespace Phpactor\Extension\Rpc\Tests\Unit\Test;

use PHPUnit\Framework\TestCase;
use Phpactor\Extension\Rpc\Handler;
use Phpactor\Extension\Rpc\Response;
use Phpactor\Extension\Rpc\Test\HandlerTester;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;

class HandlerTesterTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $handler;

    /**
     * @var ObjectProphecy
     */
    private $response;

    public function setUp()
    {
        $this->handler = $this->prophesize(Handler::class);
        $this->response = $this->prophesize(Response::class);
    }

    public function testTester()
    {
        $this->handler->name()->willReturn('foobar');
        $this->handler->configure(Argument::any())->will(function (array $args) {
            $args[0]->setRequired(['foo']);
        });
        $this->handler->handle(['foo' => 'bar'])->willReturn($this->response);

        $tester = new HandlerTester($this->handler->reveal());

        $response = $tester->handle('foobar', [ 'foo' => 'bar' ]);
        $this->assertSame($this->response->reveal(), $response);
    }
}
