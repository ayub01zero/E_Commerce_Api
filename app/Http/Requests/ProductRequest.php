<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255',
            'product_qty' => 'required|string|max:255',
            'product_tags' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'selling_price' => 'required|string|max:255',
            'discount_price' => 'nullable|string|max:255',
            'points' => 'nullable|integer|min:0',
            'short_des' => 'required|string',
            'long_des' => 'required|string',
            'show_slider' => 'nullable|integer',
            'week_deals' => 'nullable|integer',
            'special_offer' => 'nullable|integer',
            'new_products' => 'nullable|integer',
            'discount_products' => 'nullable|integer',
            'status' => 'integer|in:0,1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4000', 
        ];
    }
}
