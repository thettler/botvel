<?php

namespace Thettler\Botvel\Fakes;

use Thettler\Botvel\Contracts\ConfiguratorInterface;

class FakeConfigurator implements ConfiguratorInterface
{
    protected mixed $data = null;

    public function testData(mixed $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function toArray(): array
    {
        return ['data' => $this->data];
    }
}
