<?php

namespace Thettler\Botvel;

use Illuminate\Support\Arr;
use Thettler\Botvel\Commands\Command;
use Thettler\Botvel\Contracts\DriverInterface;
use Thettler\Botvel\Fakes\FakeDriver;

class Botvel
{
    public function __construct(
        protected BotvelRegistrar $registrar
    ) {
    }

    /**
     * @param  string  $identifier
     * @param  class-string |\Closure  $handler
     * @return Command
     */
    public function command(string $identifier, string|\Closure $handler): Command
    {
        $command = new Command($identifier, $handler);
        $this->registrar->addCommand($command);
        return $command;
    }

    public function drivers(): array
    {
        return config('botvel.drivers');
    }

    public function driver(string $key): DriverInterface
    {
        return new (Arr::first(config('botvel.drivers'), fn(string $driver) => $driver::key() === $key))();
    }

    public function driverKeys(): array
    {
        return array_map(fn(string $driver) => $driver::key(), $this->drivers());
    }


    public function fake(): static
    {
        config()->set('botvel.drivers', [FakeDriver::class]);
        return $this;
    }

}
