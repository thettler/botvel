<?php

namespace Thettler\Botvel\Commands;

use Thettler\Botvel\Facades\Botvel;

class Command
{
    protected array $driverData = [];

    public function __construct(
        public readonly string $identifier,
        /** @var class-string|\Closure $handler */
        public readonly string|\Closure $handler,
    ) {
    }

    public function configure(string $driver, callable $configCallback): static
    {
        $configurator = Botvel::driver($driver)
            ->commandConfigurator(...($this->driverData[$driver] ?? []));

        $configurator = $configCallback($configurator);

        $this->driverData[$driver] = $configurator->toArray();

        return $this;
    }

    public function getDriverConfiguration(string $driver): array
    {
        return $this->driverData[$driver];
    }


}
