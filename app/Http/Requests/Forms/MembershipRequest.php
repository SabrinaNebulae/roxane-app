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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone1' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'cgu' => 'required|accepted',
            'captcha' => ['required', new ValidCaptcha('captcha_membership')],
        ];
    }
}
