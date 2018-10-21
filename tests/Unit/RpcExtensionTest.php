<?php

namespace Phpactor\Extension\Rpc\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phpactor\Container\PhpactorContainer;
use Phpactor\Exension\Logger\LoggingExtension;
use Phpactor\Extension\Rpc\Command\RpcCommand;
use Phpactor\Extension\Rpc\RpcExtension;

class RpcExtensionTest extends TestCase
{
    public function testExtension()
    {
        $container = PhpactorContainer::fromExtensions([
            LoggingExtension::class,
            RpcExtension::class
        ], []);

        $command = $container->get('rpc.command.rpc');
        $this->assertInstanceOf(RpcCommand::class, $command);
    }
}
