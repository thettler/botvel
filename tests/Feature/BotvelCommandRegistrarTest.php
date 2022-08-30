<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can register commands', function () {
    /** @var \Thettler\Botvel\Botvel $botvel */
    $botvel = app(\Thettler\Botvel\Botvel::class);
    /** @var \Thettler\Botvel\BotvelRegistrar $registrar */
    $registrar = app(\Thettler\Botvel\BotvelRegistrar::class);

    $botvel->command('test', 'test');

    $registrar->registerCommands();
});
