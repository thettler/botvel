<?php

namespace Thettler\Botvel\Enums;

use Thettler\Botvel\Contracts\InputTypeInterface;

enum InputType : string implements InputTypeInterface
{
    case String = 'string';
    case Integer = 'int';
    case Number = 'number';
    case Boolean = 'bool';
}
