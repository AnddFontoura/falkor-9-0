<?php

namespace App\Enums;

class GenderEnum
{
    public const NEUTRAL = 3;

    public const MALE = 1;

    public const FEMALE = 2;

    public CONST GENDER_TEAM_ARRAY = [
        self::MALE => 'Masculino',
        self::FEMALE => 'Feminino',
        self::NEUTRAL => 'Misto',
    ];

    public CONST GENDER_PLAYER_ARRAY = [
        self::MALE => 'Masculino',
        self::FEMALE => 'Feminino',
    ];
}
