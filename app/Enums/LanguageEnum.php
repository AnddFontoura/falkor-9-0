<?php

namespace App\Enums;

class LanguageEnum
{
    public const EN = 'en';

    public const PT_BR = 'pt_br';

    public const LANGUAGE_ARRAY = [
        self::PT_BR => 'Português (Brasil)',
        self::EN => 'English (USA)'
    ];
}
