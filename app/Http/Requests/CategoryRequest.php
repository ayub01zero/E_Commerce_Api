<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'category_name' => ['required','max:255'],
                'img_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            ];
        }else{
             return [
            'category_name' => ['sometimes','required','max:255'],
            'img_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ];
        }
       
    }
}
