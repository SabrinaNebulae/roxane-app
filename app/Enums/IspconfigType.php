<?php

namespace App\Enums;

enum IspconfigType: string
{
    case MAIL = 'mail';
    case WEB  = 'web';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::MAIL  => 'Email',
            self::WEB   => 'Hébergement',
            self::OTHER => 'Autre',
        };
    }
}
