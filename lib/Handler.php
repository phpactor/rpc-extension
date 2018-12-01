<?php

namespace Phpactor\Extension\Rpc;

use Phpactor\MapResolver\Resolver;

interface Handler
{
    public function configure(Resolver $resolver);

    public function handle(array $arguments);

    public static function name(): string;
}
