<?php

use Thettler\Botvel\BotvelRegistrar;
use Thettler\Botvel\Commands\Command;
use Thettler\Botvel\Facades\Botvel;
use Thettler\Botvel\Fakes\FakeConfigurator;

it('can manually add commands via Facade', function () {
    Botvel::fake();
    $handler = fn () => 'test';
    Botvel::command('test', $handler)
        ->configure('fake', fn (FakeConfigurator $config) => $config->testData('Some Input'));

    expect(app(BotvelRegistrar::class)->getCommand('test'))
        ->toBeInstanceOf(Command::class)
        ->toHaveProperty('identifier', 'test')
        ->toHaveProperty('handler', $handler)
        ->getDriverConfiguration('fake')->toBe(['data' => 'Some Input']);
});
