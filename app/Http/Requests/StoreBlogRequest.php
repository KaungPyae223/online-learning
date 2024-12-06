<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            //
        'blog_name'     => 'required|string|min:3|max:255',
        'instructor_id' => 'required|exists:instructors,id',
        'blog_info'     => 'nullable|string|min:10',
        'blog_content'  => 'required|string|min:50',
        'blog_image'    => 'nullable|image|mimes:jpeg,png,jpg',
        ];
    }
}
