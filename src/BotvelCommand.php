<?php

namespace Thettler\Botvel;

class BotvelCommand
{
    public readonly string $hash;

    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly ?string $description,
        /** @var $inputs class-string */
        public readonly string $handler,
        public readonly BotvelInputCollection $inputs,
        public readonly CommandMetaCollection $meta = new CommandMetaCollection(),
    ) {
        $this->hash = md5((string) $this);
    }

    public function commandConfig(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description,
            'inputs' => $this->inputs->map(fn (BotvelInput $input) => $input->inputConfig()),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->commandConfig());
    }
}
