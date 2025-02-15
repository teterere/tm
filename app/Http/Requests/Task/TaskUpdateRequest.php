<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('modify', $task);
    }

    public function rules(): array
    {
        return [
            'title'       => ['sometimes', 'required', 'max:255'],
            'description' => ['nullable', 'max:1000']
        ];
    }
}
