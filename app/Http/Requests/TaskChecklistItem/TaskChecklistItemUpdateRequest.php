<?php

namespace App\Http\Requests\TaskChecklistItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskChecklistItemUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        $item = $this->route('item');

        return Gate::allows('update', [$item, $task]);
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255']
        ];
    }
}
