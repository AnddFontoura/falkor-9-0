<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamCreateOrUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cityId' => 'required|integer|min:1',
            'modalityId' => 'required|exists:modalities,id',
            'teamName' => 'required|string|min:1|max:254',
            'teamDescription' => 'required|string|min:1',
            'teamGender' => 'required|integer',
            'foundationDate' => 'required|date:Y-m-d',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image',
            'teamFacebook' => 'nullable|string',
            'teamInstagram' => 'nullable|string',
            'teamX' => 'nullable|string',
            'teamTiktok' => 'nullable|string',
            'teamYoutube' => 'nullable|string',
            'teamKwai' => 'nullable|string',
        ];
    }
}
