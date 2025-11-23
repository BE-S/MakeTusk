<?php

namespace App\Enums;

enum Order: string
{
    case NEWER = "newer";
    case OLDEST = "oldest";

    public static function default(): string
    {
        return self::NEWER->value;
    }
}
