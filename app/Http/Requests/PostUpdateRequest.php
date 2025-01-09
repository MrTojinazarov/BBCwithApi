<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'text' => 'required|string',
            'img' => 'nullable|image|max:2048', 
            'old_img' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Post sarlavhasi kerak.',
            'description.required' => 'Post tavsifi kerak.',
            'text.required' => 'Post matni kerak.',
            'img.image' => 'Rasm fayli bo\'lishi kerak.',
            'img.max' => 'Rasm 2MB dan oshmasligi kerak.',
            'category_id.required' => 'Kategoriya tanlanishi kerak.',
        ];
    }
}

