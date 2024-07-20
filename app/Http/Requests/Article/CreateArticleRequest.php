<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'body' => 'required',
            'status' => 'nullable|boolean',
            'words' => 'required|array',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'body' => 'متن',
            'words' => 'کلمات کلیذی',
            'date' => 'تاریخ',
            'category_id' => 'دسته بندی'
        ];
    }
}
