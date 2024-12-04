<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            "name" => "required",
            "info" => "required",
            "price" => "required|integer",
            "description" => "required",
            "can_learn" => "required",
            "skill_gain" => "required",
            "category_id" => "required|exists:categories,id",
            "level_id" => "required|exists:levels,id",
            "language_id" => "required|exists:languages,id",
            "instructor_id" => "required|exists:instructors,id",
            "course_image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048"
        ];
    }
}
