<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskUpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('modify', $task);
    }

    public function rules(): array
    {
        return [
            'order' => ['integer', 'min:0']
        ];
    }
}
