<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use App\Rules\ValidEstimateFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('modify', $task);
    }

    public function rules(): array
    {
        $task = $this->route('task');

        return [
            'title'       => ['sometimes', 'required', 'max:255'],
            'description' => ['nullable', 'max:' . Task::MAX_DESCRIPTION_LENGTH],
            'due_date'    => ['nullable', 'date'],
            'estimate'    => ['nullable', 'string', 'regex:/[dhm]/', new ValidEstimateFormat()],
            'assignee_id' => [
                'nullable',
                'exists:users,id',
                Rule::exists('users', 'id')->where('company_id', $task->company_id)
            ],
        ];
    }
}
