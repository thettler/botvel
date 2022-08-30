<?php

use Thettler\Botvel\Factories\BotvelInputFactory;

it('can create a basic input from factory', function () {
    $factory = new \Thettler\Botvel\Factories\BotvelInputFactory();

    $factory = $factory->name('Test')
        ->description('Description')
        ->required()
        ->type(\Thettler\Botvel\Enums\InputType::Integer)
        ->choices([]);

    expect($factory->create())
        ->toBeInstanceOf(\Thettler\Botvel\BotvelInput::class)
        ->toHaveProperty('name', 'Test')
        ->toHaveProperty('description', 'Description')
        ->toHaveProperty('isRequired', true)
        ->toHaveProperty('choices', []);
});

