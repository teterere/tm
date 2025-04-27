<?php

namespace App\Http\Requests\Task;

use App\Rules\ValidEstimateFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'required', 'max:255'],
            'description' => ['nullable', 'max:6000'],
            'due_date'    => ['nullable', 'date'],
            'estimate'    => ['nullable', 'string', 'regex:/[dhm]/', new ValidEstimateFormat()],
            'assignee_id' => [
                'nullable',
                'exists:users,id',
                Rule::exists('users', 'id')->where('company_id', auth()->user()->company_id)
            ],
        ];
    }
}
