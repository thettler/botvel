<?php

namespace Thettler\Botvel;

use Thettler\Botvel\Enums\InputType;

class BotvelInput
{
    public function __construct(
        public readonly string $name,
        public readonly InputType $type,
        public readonly ?string $description,
        public readonly array $choices = [],
        public readonly bool $isRequired = false,
    ) {
    }

    public function inputConfig(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
            'description' => $this->description,
            'choices' => $this->choices,
            'isRequired' => $this->isRequired,
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->inputConfig());
    }
}
