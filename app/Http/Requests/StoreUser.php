<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\EmailDomainRule;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'name' => ['required','max:25'],
           'email' => ['required','email','unique:users,email', new EmailDomainRule],
           'password' => ['required','min:8'],
           'phone' => ['required','max:11'],
           'address' => ['required','max:30'],
        ];
    }
}
