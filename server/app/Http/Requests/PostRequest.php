<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:20'],
            'content' => ['required', 'min:200'],
            'category' => ['required', 'min:3'],
            'status' => ['required', Rule::in('Publish', 'Draft', 'Trash')],
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => 'A Title is required',
            'title.min'      => 'Minimal 20 karakter',
            'content.required'    => 'A Content is required',
            'content.min'      => 'Minimal 200 karakter',
            'category.required'    => 'A Category is required',
            'category.min'      => 'Minimal 3 karakter',
            'status.required'      => 'must choose one of Publish, Draft, Trash,',
            'status.in'      => 'must choose one of Publish, Draft, Trash,',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'message' => $validator->errors()
        ]));
    }
}
