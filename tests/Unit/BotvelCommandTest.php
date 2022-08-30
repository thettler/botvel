<?php

it('can create a hash based on its config', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $command = $factory
        ->key('unique-key')
        ->name('Test')
        ->description('Description')
        ->handler('Handler')
        ->create();

    $sameCommand = $factory
        ->key('unique-key')
        ->name('Test')
        ->description('Description')
        ->handler('Handler')
        ->create();


    expect($command->hash)->toBe($sameCommand->hash);
});

it('changes hash if input changes', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $command = $factory
        ->key('unique-key')
        ->name('Test')
        ->inputs(fn(\Thettler\Botvel\Factories\BotvelInputFactory $factory)=> $factory->name('Input'))
        ->description('Description')
        ->handler('Handler')
        ->create();

    $sameCommand = $factory
        ->key('unique-key')
        ->name('Test')
        ->inputs(fn(\Thettler\Botvel\Factories\BotvelInputFactory $factory)=> $factory->name('Changed Input'))
        ->description('Description')
        ->handler('Handler')
        ->create();


    expect($command->hash)->not->toBe($sameCommand->hash);
});
