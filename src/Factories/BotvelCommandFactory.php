<?php

namespace Thettler\Botvel\Factories;

use Illuminate\Support\Arr;
use Thettler\Botvel\Botvel;
use Thettler\Botvel\BotvelCommand;
use Thettler\Botvel\BotvelInput;
use Thettler\Botvel\BotvelInputCollection;
use Thettler\Botvel\CommandMetaCollection;
use Thettler\Botvel\Contracts\Driver\BotvelDriver;
use Thettler\Botvel\Exceptions\BotvelException;

class BotvelCommandFactory
{
    public function __construct(
        protected ?string $key = null,
        protected ?string $name = null,
        protected ?string $description = null,
        /** @var $inputs class-string|null */
        protected ?string $handler = null,
        protected ?BotvelInputCollection $inputs = null,
        protected CommandMetaCollection $meta = new CommandMetaCollection(),
    ) {
    }

    public function key(string $key): BotvelCommandFactory
    {
        $this->key = $key;
        return $this;
    }

    public function name(string $name): BotvelCommandFactory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param  string  $description
     * @return BotvelCommandFactory
     */
    public function description(string $description): BotvelCommandFactory
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param  class-string  $handler
     * @return BotvelCommandFactory
     */
    public function handler(string $handler): BotvelCommandFactory
    {
        $this->handler = $handler;
        return $this;
    }

    /**
     * @param  callable(BotvelInputFactory): BotvelInputFactory|BotvelInputFactory[]  $inputFactories
     * @return $this
     */
    public function inputs(callable $inputFactories): BotvelCommandFactory
    {
        $inputFactories = Arr::wrap($inputFactories(new BotvelInputFactory()));
        $this->inputs = new BotvelInputCollection(
            array_map(fn(BotvelInputFactory $factory) => $factory->create(), $inputFactories)
        );

        return $this;
    }

    public function driver(string $key, callable $data): self
    {
        /** @var Botvel $botvel */
        $botvel = app(Botvel::class);

        /** @var BotvelDriver $driver */
        $driver = $botvel->driverFor($key);

        $this->meta->put($key, $data($driver->commandConfig()));
        return $this;
    }

    public function create(): BotvelCommand
    {

        if (!$this->key){
            throw new BotvelException('A command needs to have a unique key! You can add it by calling the ->key() method on the Factory.');
        }

        if (!$this->name){
            throw new BotvelException('A command needs to have a name! You can add it by calling the ->name() method on the Factory.');
        }

        if (!$this->handler){
            throw new BotvelException('A command needs to have a handler! You can add it by calling the ->handler() method on the Factory.');
        }

        return new BotvelCommand(
            key: $this->key,
            name: $this->name,
            description: $this->description,
            handler: $this->handler,
            inputs: $this->inputs ?? BotvelInputCollection::make(),
            meta: $this->meta
        );
    }
}
