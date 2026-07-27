<?php

namespace App\Http\Requests\Forms;

use App\Rules\ValidCaptcha;
use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone1.digits' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
            'zipcode.digits' => 'Le code postal doit contenir exactement 5 chiffres.',
        ];
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_type' => 'required|string|exists:member_types,identifier',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'desired_retzien_email' => ['nullable', 'string', 'max:64', 'regex:/^[a-z0-9._-]+$/'],
            'address' => 'required|string|max:255',
            'zipcode' => ['required', 'digits:5'],
            'city' => 'required|string|max:255',
            'phone1' => ['required', 'digits:10'],
            'package' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'cgu' => 'required|accepted',
            'captcha' => ['required', new ValidCaptcha('captcha_membership')],
        ];
    }
}
