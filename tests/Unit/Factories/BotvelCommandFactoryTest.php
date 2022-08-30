<?php

use Thettler\Botvel\Drivers\NullDriver\NullCommandConfig;
use Thettler\Botvel\Drivers\NullDriver\NullDriver;
use Thettler\Botvel\Factories\BotvelInputFactory;

it('can create a basic command from factory', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory
        ->key('unique-key')
        ->name('Test')
        ->description('Description')
        ->handler('Handler');

    expect($factory->create())
        ->toBeInstanceOf(\Thettler\Botvel\BotvelCommand::class)
        ->toHaveProperty('key', 'unique-key')
        ->toHaveProperty('hash')
        ->toHaveProperty('name', 'Test')
        ->toHaveProperty('description', 'Description')
        ->toHaveProperty('handler', 'Handler');
});


it('can create a command with input', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory->name('Test')
        ->key('unique-key')
        ->description('Description')
        ->handler('Handler')
        ->inputs(fn(BotvelInputFactory $input) => $input->name('input1'));

    expect($factory->create()->inputs)
        ->toBeInstanceOf(\Thettler\Botvel\BotvelInputCollection::class)
        ->toHaveCount(1)
        ->first()
        ->toHaveProperty('name', 'input1');
});

it('can create a command with inputs', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory->name('Test')
        ->key('unique-key')
        ->description('Description')
        ->handler('Handler')
        ->inputs(fn(BotvelInputFactory $input) => [$input->name('input1'), $input->name('input2')]);

    expect($factory->create()->inputs)
        ->toBeInstanceOf(\Thettler\Botvel\BotvelInputCollection::class)
        ->toHaveCount(2)
        ->sequence(
            fn(\Pest\Expectation $input)=> $input->toHaveProperty('name', 'input1'),
            fn(\Pest\Expectation $input)=> $input->toHaveProperty('name', 'input2')
        );
});

it('can not create a command with missing name', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory
        ->key('unique-key')
        ->handler('estt')
        ->create();
})
    ->expectException(\Thettler\Botvel\Exceptions\BotvelException::class)
    ->expectExceptionMessage('A command needs to have a name! You can add it by calling the ->name() method on the Factory.');

it('can not create a command with missing handler', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory
        ->key('unique-key')
        ->name('test')
        ->create();
})
    ->expectException(\Thettler\Botvel\Exceptions\BotvelException::class)
    ->expectExceptionMessage('A command needs to have a handler! You can add it by calling the ->handler() method on the Factory.');

it('can not create a command with missing key', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory
        ->handler('estt')

        ->name('test')
        ->create();
})
    ->expectException(\Thettler\Botvel\Exceptions\BotvelException::class)
    ->expectExceptionMessage('A command needs to have a unique key! You can add it by calling the ->key() method on the Factory.');


it('can create a command with driver specific data', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelCommandFactory();

    $factory
        ->key('unique-key')
        ->name('test')
        ->handler('estt')
        ->driver(
        NullDriver::key(),
        fn(NullCommandConfig $config) =>  expect($config)->toBeInstanceOf(NullCommandConfig::class)->value
    );

    expect($factory->create()->meta->get(NullDriver::key()))
        ->toBeInstanceOf(NullCommandConfig::class);
});
