<?php

use Thettler\Botvel\Facades\Botvel;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can migrate a new command', function () {
    $command = Botvel::command('test');

    \Thettler\Botvel\BotvelMigrator::commands($command)
        ->migrate();

});
