<?php

namespace App\Enum;

enum WeightConversionEnum: int
{
    case GAP_0 = 0;
    case GAP_1 = 1;
    case GAP_NEG_1 = -1;
    case GAP_2 = 2;
    case GAP_NEG_2 = -2;
    case GAP_3 = 3;
    case GAP_NEG_3 = -3;
    case GAP_4 = 4;
    case GAP_NEG_4 = -4;

    public static function fromGap(int $gap): float
    {
        return match ($gap) {
            0 => 5.0,
            1 => 4.5,
            -1 => 4.0,
            2 => 3.5,
            -2 => 3.0,
            3 => 2.5,
            -3 => 2.0,
            4 => 1.5,
            -4 => 1.0,
            default => 0.0,
        };
    }
}
