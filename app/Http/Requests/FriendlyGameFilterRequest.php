<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FriendlyGameFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'matchDay' => 'nullable|date',
            'matchDayBetween' => 'nullable|date',
            'matchDuration' => 'nullable|hour',
            'matchCityId' => 'nullable|int',
            'matchStateId' => 'nullable|int',
            'matchHasOpponent' => 'nullable|int',
            'matchTeamId' => 'nullable|int',
        ];
    }
}
