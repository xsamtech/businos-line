<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
            'address_1' => ['required', 'string', 'max:2000'],
            'address_2' => ['nullable', 'string', 'max:2000'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'avatar_base64' => ['nullable', 'string', 'max:3000000', 'regex:/^data:image\/(jpeg|png|webp);base64,/'],
        ];
    }
}
