<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // 🔥 TAMBAHAN PROFIL DONATUR
            'no_telp' => ['nullable', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],

            // SESUAIKAN DENGAN VALUE FORM (L / P)
            'jenis_kelamin' => ['nullable', 'in:L,P'],

            'alamat' => ['nullable', 'string', 'max:500'],

            // OPTIONAL (kalau dipakai di DB)
            'rt' => ['nullable', 'in:01,02,03,04,05,06'],
        ];
    }
}