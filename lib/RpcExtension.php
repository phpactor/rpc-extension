<?php

namespace Phpactor\Extension\Rpc;

use Phpactor\Container\Container;
use Phpactor\Container\ContainerBuilder;
use Phpactor\Container\Extension;
use Phpactor\Exension\Logger\LoggingExtension;
use Phpactor\Extension\Rpc\Command\RpcCommand;
use Phpactor\Extension\Rpc\Handler\EchoHandler;
use Phpactor\Extension\Rpc\RequestHandler\ExceptionCatchingHandler;
use Phpactor\Extension\Rpc\RequestHandler\LoggingHandler;
use Phpactor\Extension\Rpc\RequestHandler\RequestHandler;
use Phpactor\MapResolver\Resolver;

class RpcExtension implements Extension
{
    const TAG_RPC_HANDLER = 'rpc.handler';

    public const SERVICE_REQUEST_HANDLER = 'rpc.request_handler';

    /**
     * {@inheritDoc}
     */
    public function load(ContainerBuilder $container)
    {
        $container->register('rpc.command.rpc', function (Container $container) {
            return new RpcCommand(
                $container->get('rpc.request_handler'),
                $container->getParameter('rpc.replay_path'),
                $container->getParameter('rpc.store_replay')
            );
        }, [ 'console.command' => [] ]);

        $container->register(self::SERVICE_REQUEST_HANDLER, function (Container $container) {
            return new LoggingHandler(
                new ExceptionCatchingHandler(
                    new RequestHandler($container->get('rpc.handler_registry'))
                ),
                $container->get(LoggingExtension::SERVICE_LOGGER)
            );
        });

        $container->register('rpc.handler_registry', function (Container $container) {
            $handlers = [];
            foreach (array_keys($container->getServiceIdsForTag(self::TAG_RPC_HANDLER)) as $serviceId) {
                $handlers[] = $container->get($serviceId);
            }

            return new HandlerRegistry($handlers);
        });

        $this->registerHandlers($container);
    }

    private function registerHandlers(ContainerBuilder $container)
    {
        $container->register('rpc.handler.echo', function (Container $container) {
            return new EchoHandler();
        }, [ self::TAG_RPC_HANDLER => [] ]);
    }

    /**
     * {@inheritDoc}
     */
    public function configure(Resolver $schema)
    {
        $schema->setDefaults([
            'rpc.store_replay' => false,
            'rpc.replay_path' => getcwd() . '/phpactor-replay.json',
        ]);
    }
}
