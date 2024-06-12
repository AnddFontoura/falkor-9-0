<?php

namespace App\Enums;

class GenderEnum
{
    public const NEUTRAL = 0;

    public const MALE = 1;

    public const FEMALE = 2;

    public CONST GENDER_TEAM_ARRAY = [
        self::NEUTRAL => 'Misto',
        self::MALE => 'Masculino',
        self::FEMALE => 'Feminino'
    ];

    public CONST GENDER_PLAYER_ARRAY = [
        self::MALE => 'Masculino',
        self::FEMALE => 'Feminino'
    ];
}
