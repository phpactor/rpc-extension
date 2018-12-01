<?php

namespace Phpactor\Extension\Rpc\Tests\Unit\Test;

use PHPUnit\Framework\TestCase;
use Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor\Extension\Rpc\Response\EchoResponse;
use Phpactor\Extension\Rpc\Test\HandlerTester;
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
        $this->handler = new EchoHandler();
    }

    public function testTester()
    {
        $tester = new HandlerTester($this->handler);

        $response = $tester->handle('echo', [ 'message' => 'bar' ]);
        $this->assertInstanceOf(EchoResponse::class, $response);
        $this->assertEquals('bar', $response->message());
    }
}
