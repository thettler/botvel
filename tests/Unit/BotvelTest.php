<?php

use Thettler\Botvel\Exceptions\BotvelCommandRegistrationException;

it('can register commands', function () {
    /** @var \Thettler\Botvel\Botvel $botvel */
    $botvel = app(\Thettler\Botvel\Botvel::class);

    $botvel->command(
        'Test Command',
        'Handler',
        fn (\Thettler\Botvel\Factories\BotvelCommandFactory $factory) => $factory->description('Description')
    );

    expect($botvel->getRegisteredCommands())
        ->toHaveCount(1)
        ->first()
        ->toHaveProperty('key', 'test-command')
        ->toHaveProperty('name', 'Test Command')
        ->toHaveProperty('handler', 'Handler')
        ->toHaveProperty('description', 'Description');
});

it('can register commands without config', function () {
    /** @var \Thettler\Botvel\Botvel $botvel */
    $botvel = app(\Thettler\Botvel\Botvel::class);

    $botvel->command('Test Command', 'Handler');

    expect($botvel->getRegisteredCommands())
        ->toHaveCount(1)
        ->first()
        ->toHaveProperty('key', 'test-command')
        ->toHaveProperty('name', 'Test Command')
        ->toHaveProperty('handler', 'Handler')
        ->toHaveProperty('description', '');
});

it('can not register commands with same key', function () {
    /** @var \Thettler\Botvel\Botvel $botvel */
    $botvel = app(\Thettler\Botvel\Botvel::class);

    $botvel->command('Test Command', 'Handler');
    $botvel->command('Test Command', 'Handler');
})->throws(BotvelCommandRegistrationException::class, 'Command with key: "test-command" already exist. Keys must be unique.');
