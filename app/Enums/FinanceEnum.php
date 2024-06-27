<?php

namespace App\Enums;

class FinanceEnum
{
    public const DEBIT = 0;

    public const CREDIT = 1;

    public const SELECT_TYPE = [
        self::DEBIT => 'team-finances.debit',
        self::CREDIT => 'team-finances.credit',
    ];

    public const SELECT_FORM_ORIGINS = [
        'team-finances.select.monthly',
        'team-finances.select.donation',
        'team-finances.select.sponsorship',
        'team-finances.select.new-uniforms',
        'team-finances.select.cleaning-uniforms',
        'team-finances.select.materials',
        'team-finances.select.payments',
        'team-finances.select.investments',
        'team-finances.select.other',
    ];

    public const FIELD_VALUE = 'team-finances.database.field_value';

    public const REFEREE_VALUE = 'team-finances.database.referee_value';

    public const OTHER_VALUE = 'team-finances.database.other_value';

    public const MATCH_PAYMENT_VALUE = 'team-finances.database.match_payment_value';
}
