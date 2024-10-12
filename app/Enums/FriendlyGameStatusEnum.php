<?php

namespace App\Enums;

class FriendlyGameStatusEnum
{
    public CONST GAME_STATUS_PENDING = 'Aguardando resposta';

    public CONST GAME_STATUS_ACCEPTED = 'Aprovado';

    public CONST GAME_STATUS_REJECTED = 'Rejeitado';

    public const GAME_STATUS_ARRAY = [
        self::GAME_STATUS_PENDING,
        self::GAME_STATUS_ACCEPTED,
        self::GAME_STATUS_REJECTED,
    ];
}
