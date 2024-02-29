<?php

namespace App\Http\Requests\V1\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUsersRequest extends FormRequest
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
            'search' => [
                'nullable',
                'string',
                'max:255'
            ],
            'per_page' => [
                'nullable',
                'numeric',
                'max:30'
            ],
            'sort_by' => [
                'nullable',
                Rule::in([
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ])
            ],
            'order' => [
                'required_with:sort_by',
                'nullable',
                'in:asc,desc'
            ]
        ];
    }
}
