<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'total_amount' => 'required|numeric',
            'notes' => 'nullable|string',
            'payment_method' => 'required|string',
            'used_point' => 'nullable|numeric',
            'cartData' => 'required|array',
            'cartData.*.id' => 'required|integer',
            'cartData.*.qty' => 'required|integer',
            'cartData.*.price' => 'required|numeric',
        ];
    }
}
