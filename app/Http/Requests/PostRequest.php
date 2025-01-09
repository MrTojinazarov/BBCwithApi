<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Post sarlavhasi kerak.',
            'title.string' => 'Post sarlavhasi matn bo\'lishi kerak.',
            'title.max' => 'Post sarlavhasi 255 ta belgidan oshmasligi kerak.',
            'description.required' => 'Post tavsifi kerak.',
            'description.string' => 'Post tavsifi matn bo\'lishi kerak.',
            'text.required' => 'Post matni kerak.',
            'text.string' => 'Post matni matn bo\'lishi kerak.',
            'img.image' => 'Rasm fayli bo\'lishi kerak.',
            'img.max' => 'Rasm 2MB dan oshmasligi kerak.',
            'category_id.required' => 'Kategoriya tanlanishi kerak.',
            'category_id.exists' => 'Tanlangan kategoriya mavjud emas.',
        ];
    }
}
