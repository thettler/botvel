<?php
// config for Thettler/Botvel
use Thettler\Botvel\Drivers\NullDriver\NullDriver;

return [
    'drivers' => [
        NullDriver::key() => [
            'driver' => NullDriver::class,
        ]
    ],
];
