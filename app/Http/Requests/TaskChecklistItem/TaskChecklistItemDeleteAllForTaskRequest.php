<?php

namespace App\Http\Requests\TaskChecklistItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskChecklistItemDeleteAllForTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('deleteAllChecklistItems', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }
}
