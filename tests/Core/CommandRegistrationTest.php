<?php

use Thettler\Botvel\BotvelArgument;
use Thettler\Botvel\Exceptions\RegisteredCommandValidationException;
use Thettler\Botvel\Facades\Botvel;
use Thettler\Botvel\RegisteredBotvelCommand;

it('can register a basic command without basic config', function () {
    config()->set('botvel.default_bot', 'defaultBot');

    $command = Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->description('Some Description')
        ->action(fn () => '')
    );

    expect(Botvel::commands())
        ->toHaveCount(1)
        ->and(Botvel::store()->find($command->getKey()))
        ->toBeInstanceOf(RegisteredBotvelCommand::class)
        ->getName()->toBe('inspire')
        ->isScoped()->toBeFalse()
        ->isGlobal()->toBeTrue()
        ->getBot()->toBe('defaultBot')
        ->getDescription()->toBe('Some Description');
});

it('can register a basic command with custom key', function () {
    Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->key('custom-key')
    );

    expect(Botvel::store()->find('custom-key'))
        ->not
        ->toBeNull();
});

it('can not register a command with to large description', function () {
    Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->description(\Illuminate\Support\Str::random(101))
    );
})->expectException(RegisteredCommandValidationException::class);

it('can register a scoped command without basic config', function () {
    $command = Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->scopes('discord', 'custom-scope')
    );

    expect(Botvel::store()->find($command->getKey()))
        ->isScoped()->toBeTrue()
        ->getScopes()->toEqual(['discord' => ['custom-scope']]);
});

it('can register a global command without basic config', function () {
    $command = Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->global()
    );

    expect(Botvel::store()->find($command->getKey()))
        ->isGlobal()->toBeTrue()
        ->getScopes()->toEqual(null);
});

it('can register a basic command with specific bot', function () {
    $command = Botvel::command('inspire', fn (RegisteredBotvelCommand $command) => $command
        ->bot('customBot')
    );

    expect(Botvel::store()->find($command->getKey()))
        ->getBot()->toBe('customBot');
});

it('can register a basic command with arguments', function () {
    $argument = BotvelArgument::make('test');
    $command = Botvel::command(
        'inspire',
        fn (RegisteredBotvelCommand $command) => $command
            ->arguments($argument)
    );

    expect(Botvel::store()->find($command->getKey())->getArguments())
        ->toHaveCount(1)
        ->first()->toBe($argument);
});
