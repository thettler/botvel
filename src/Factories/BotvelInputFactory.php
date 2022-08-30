<?php

namespace Thettler\Botvel\Factories;

use Thettler\Botvel\BotvelInput;
use Thettler\Botvel\Contracts\InputTypeInterface;
use Thettler\Botvel\Enums\InputType;

class BotvelInputFactory
{
    public function __construct(
        protected ?string $name = null,
        protected ?string $description = null,
        protected InputTypeInterface $type = InputType::String,
        protected ?array $choices = null,
        protected bool $isRequired = false,
    ) {
    }

    public function name(string $name): BotvelInputFactory
    {
        return $this->setAttribute('name', $name);
    }

    public function description(string $description): BotvelInputFactory
    {
        return $this->setAttribute('description', $description);
    }

    public function type(InputTypeInterface $type): BotvelInputFactory
    {
        return $this->setAttribute('type', $type);
    }

    public function choices(array $choices): BotvelInputFactory
    {
        return $this->setAttribute('choices', $choices);
    }

    public function required(bool $required = true): BotvelInputFactory
    {
        return $this->setAttribute('isRequired', $required);
    }

    protected function setAttribute(string $name, mixed $value): BotvelInputFactory
    {
        $self = clone $this;
        $self->$name = $value;

        return $self;
    }

    public function create(): BotvelInput
    {
        return new BotvelInput(
            name: $this->name,
            type: $this->type,
            description: $this->description,
            choices: $this->choices ?? [],
            isRequired: $this->isRequired
        );
    }
}
