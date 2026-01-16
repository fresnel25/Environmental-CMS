<?php

namespace App\Enum;

final class BlocType
{
    public const TEXTE = 'text';
    public const MEDIA = 'media';
    public const VISUALISATION = 'visualisation';

    public static function all(): array
    {
        return [
            self::TEXTE,
            self::MEDIA,
            self::VISUALISATION
        ];
    }
}
