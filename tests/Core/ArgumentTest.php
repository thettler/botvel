<?php

use Thettler\Botvel\BotvelArgument;
use Thettler\Botvel\Enums\BotvelArgumentType;

it('can create a basic Argument', function () {
    expect(BotvelArgument::make('test'))
        ->toBeInstanceOf(BotvelArgument::class)
        ->getName()->toEqual('test')
        ->getDescription()->toEqual('')
        ->isOptional()->toBeTrue()
        ->getType()->toEqual(BotvelArgumentType::String);
});


it('can create a complex Argument', function () {
    expect(
        BotvelArgument::make('test')
        ->description('Some Description')
        ->type(BotvelArgumentType::Integer)
        ->required()
    )
        ->toBeInstanceOf(BotvelArgument::class)
        ->getName()->toEqual('test')
        ->getDescription()->toEqual('Some Description')
        ->isOptional()->toBeFalse()
        ->isRequired()->toBeTrue()
        ->getType()->toEqual(BotvelArgumentType::Integer);
});

it('can not create a argument with to large description', function () {
    BotvelArgument::make('test')
        ->description(\Illuminate\Support\Str::random(101));

})->expectException(\Thettler\Botvel\Exceptions\BotvelArgumentValidationException::class);
