<?php

namespace Thettler\Botvel\Contracts;

interface DriverInterface
{
    public static function key(): string;

    public static function commandConfigurator(mixed ... $props): ConfiguratorInterface;
}
