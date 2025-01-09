<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules()
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;
    
        return [
            'name' => 'required|string|max:255|unique:categories,name' . ($categoryId ? ',' . $categoryId : ''),
            'is_active' => 'nullable|boolean',
        ];
    }
    

    public function messages()
    {
        return [
            'name.required' => 'Kategoriya nomi kiritilishi shart.',
            'name.unique' => 'Bu kategoriya nomi avval kiritilgan.',
            'name.string' => 'Kategoriya nomi matn bo`lishi kerak.',
            'name.max' => 'Kategoriya nomi maksimal 255 belgidan iborat bo`lishi kerak.',
            'is_active.boolean' => 'Aktiv holat to`g`ri yoki noto`g`ri bo`lishi kerak.',
        ];
    }
    
}
