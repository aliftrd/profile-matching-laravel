<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CompetitionCriteriaType: string implements HasLabel, HasColor
{
    case CORE = 'core';
    case SECONDARY = 'secondary';

    public function getLabel(): string
    {
        return match ($this) {
            self::CORE => 'Core Factor',
            self::SECONDARY => 'Secondary Factor',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CORE => 'primary',
            self::SECONDARY => 'success',
        };
    }
}
