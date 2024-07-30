<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdsRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:30|',
            'link' => 'required|string|url',
<<<<<<< HEAD
            'status'=> 'boolean',
            'type' => 'required|in:بنر سکشن 4,بنر سکشن 3,بنر سکشن 2 ,بنر سکشن 1, بنر صفحه دسته بندی , بنر صفحه اصلی 2, بنر صفحه اصلی 1',
=======
            'status'=> 'nullable|boolean',
            'ad_place' => 'required|in:بنر صفحه اصلی 1,بنر صفحه اصلی 2,بنر صفحه دسته بندی,بنر سکشن 1,بنر سکشن 2,بنر سکشن 3,بنر سکشن 4',
>>>>>>> 3e8cc3ae77793368004669258f88680580dc7666
            'starts_at'=> 'required|date',
            'ends_at'=>'required|date'

        ];

    }
    public function attributes(): array
    {
        return [
            'title' =>'عنوان تبلیغ',
            'link' => 'لینک',
            'status'=> 'فعال/غیرفعال',
            'ad_place' => 'انتخاب جایگاه',
            'starts_at'=> 'تاریخ شروع',
            'ends_at'=>'تاریخ انقضا'
        ];
    }
}
