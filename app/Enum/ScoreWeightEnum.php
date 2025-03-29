<?php

namespace App\Enum;

enum ScoreWeightEnum: int
{
    case EXCELLENT = 5;
    case VERY_GOOD = 4;
    case GOOD = 3;
    case AVERAGE = 2;
    case POOR = 1;
    case NONE = 0;

    private const THRESHOLD_EXCELLENT = 85;
    private const THRESHOLD_VERY_GOOD = 75;
    private const THRESHOLD_GOOD = 65;
    private const THRESHOLD_AVERAGE = 50;
    private const THRESHOLD_POOR = 0;

    public static function fromScore(int $score): self
    {
        return match (true) {
            $score > self::THRESHOLD_EXCELLENT => self::EXCELLENT,
            $score > self::THRESHOLD_VERY_GOOD => self::VERY_GOOD,
            $score > self::THRESHOLD_GOOD => self::GOOD,
            $score > self::THRESHOLD_AVERAGE => self::AVERAGE,
            $score < self::THRESHOLD_POOR => self::POOR,
            default => self::NONE,
        };
    }
}
