<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FriendlyGameCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ownedTeamId' => 'required|integer|exists:teams,id',
            'cityId' => 'required|integer|exists:cities,id',
            'matchDate' => 'required|date',
            'matchStart' => 'required|date_format:H:i',
            'matchDuration' => 'required|date_format:H:i',
            'matchCost' => 'required|regex:/' . __('general.numbers.money_pattern') . '/',
            'teamFirstUniform' => 'required|string|max:10',
            'teamSecondUniform' => 'required|string|max:10',
            'matchDescription' => 'nullable|string',
        ];
    }
}
