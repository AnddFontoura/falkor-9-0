<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FriendlyGameOpponentCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'opponentTeamId' => 'required|int|exists:teams,id',
            'opponent1stUniform' => 'required|string',
            'opponent2ndUniform' => 'required|string',
        ];
    }
}
