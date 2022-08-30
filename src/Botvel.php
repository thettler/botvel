<?php

namespace Thettler\Botvel;

use Illuminate\Support\Str;
use Thettler\Botvel\Contracts\Driver\BotvelDriver;
use Thettler\Botvel\Exceptions\BotvelCommandRegistrationException;
use Thettler\Botvel\Exceptions\BotvelException;
use Thettler\Botvel\Factories\BotvelCommandFactory;

class Botvel
{

    public function __construct(
        protected BotvelCommandCollection $registeredCommands = new BotvelCommandCollection()
    ) {
    }

    /**
     * @param  string  $name
     * @param  string  $handler
     * @param  callable(BotvelCommandFactory): BotvelCommandFactory  $configuration
     * @return $this
     */
    public function command(string $name, string $handler, ?callable $configuration = null): self
    {
        return $this->commandWithKey(Str::slug($name), $name, $handler, $configuration);
    }

    public function commandWithKey(string $key, string $name, string $handler, ?callable $configuration = null): self
    {
        if ($this->registeredCommands->keyExist($key)) {
            throw new BotvelCommandRegistrationException("Command with key: \"{$key}\" already exist. Keys must be unique.");
        }

        /** @var BotvelCommandFactory $factory */
        $factory = app(BotvelCommandFactory::class);

        $factory->name($name)
            ->key($key)
            ->handler($handler);

        if ($configuration) {
            $factory = $configuration($factory);
        }

        $this->registeredCommands->push($factory->create());
        return $this;
    }

    public function driverFor(string $key): BotvelDriver
    {
        if (!config()->has("botvel.drivers.{$key}.driver")) {
            throw new BotvelException('Driver for key "'.$key.'" does not exist.');
        }

        return app(config("botvel.drivers.{$key}.driver"));
    }

    public function getRegisteredCommands(): BotvelCommandCollection
    {
        return $this->registeredCommands;
    }
}
