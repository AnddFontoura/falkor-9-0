<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'teamName' => 'nullable|string|min:1|max:254',
            'teamGender' => 'nullable|integer',
            'cityId' => 'nullable|integer',
            'stateId' => 'nullable|integer',
            'modalityId' => 'nullable|integer',
            'allowApplication' => 'nullable|boolean',
        ];
    }
}
