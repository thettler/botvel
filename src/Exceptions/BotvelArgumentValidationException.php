<?php

namespace Thettler\Botvel\Exceptions;

use Thettler\Botvel\BotvelArgument;

class BotvelArgumentValidationException extends BotvelException
{
    public static function descriptionLength(BotvelArgument $argument): self
    {
        return new self("[Command: {$argument->getName()}] The description for commands must be between 1-100 characters.");
    }
}
