<?php

namespace Thettler\Botvel;

use Illuminate\Support\Collection;
use Thettler\Botvel\Exceptions\RegisteredCommandValidationException;

class RegisteredBotvelCommand
{
    public function __construct(
        protected string $name,
        protected string $bot,
        protected string $key = '',
        protected string $description = '',
        protected ?array $scopes = null,
        protected Collection $arguments = new Collection(),
    ) {
    }

    /**
     * @param  callable|class-string  $action
     * @return $this
     */
    public function action(callable|string $action): static
    {
        return $this;
    }

    public function key(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    public function bot(string $bot): static
    {
        $this->bot = $bot;
        return $this;
    }

    public function arguments(BotvelArgument...$arguments): static
    {
        $this->arguments = collect($arguments);
        return $this;
    }

    public function scopes(string $platform, string...$scopes): static
    {
        $this->scopes[$platform] = $scopes;
        return $this;
    }

    public function global(): static
    {
        $this->scopes = null;
        return $this;
    }

    public function description(string $description): static
    {
        if (strlen($description) <= 0 || strlen($description) > 100) {
            throw RegisteredCommandValidationException::descriptionLength($this);
        }

        $this->description = $description;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getScopes(): null|array
    {
        return $this->scopes;
    }

    public function isScoped(): bool
    {
        return $this->getScopes() !== null;
    }

    public function isGlobal(): bool
    {
        return $this->getScopes() === null;
    }

    public function getBot(): string
    {
        return $this->bot;
    }

    public function getArguments(): Collection
    {
        return $this->arguments;
    }
}
