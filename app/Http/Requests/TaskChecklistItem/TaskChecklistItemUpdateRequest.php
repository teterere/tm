<?php

namespace App\Http\Requests\TaskChecklistItem;

use Illuminate\Contracts\Validation\ValidationRule;
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

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string', 'max:255']
        ];
    }
}
