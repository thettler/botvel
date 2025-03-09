<?php

namespace Thettler\Botvel;

use Thettler\Botvel\Enums\BotvelArgumentType;
use Thettler\Botvel\Exceptions\BotvelArgumentValidationException;
use Thettler\Botvel\Exceptions\RegisteredCommandValidationException;

class BotvelArgument
{
    public function __construct(
        protected string $name,
        protected string $description = '',
        protected BotvelArgumentType $type = BotvelArgumentType::String,
        protected bool $required = false,
    ) {
    }

    public static function make(string $name): self
    {
        return new self($name);
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): BotvelArgumentType
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isOptional(): bool
    {
        return !$this->required;
    }

    public function description(string $description): self
    {
        if (strlen($description) <= 0 || strlen($description) > 100) {
            throw BotvelArgumentValidationException::descriptionLength($this);
        }

        $this->description = $description;
        return $this;
    }

    public function type(BotvelArgumentType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function required(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }
}
