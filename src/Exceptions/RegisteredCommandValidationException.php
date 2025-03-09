<?php

namespace Thettler\Botvel\Exceptions;

use Thettler\Botvel\RegisteredBotvelCommand;

class RegisteredCommandValidationException extends BotvelException
{
    public static function descriptionLength(RegisteredBotvelCommand $command): self
    {
        return new self("[Command: {$command->getName()}] The description for commands must be between 1-100 characters.");
    }
}
