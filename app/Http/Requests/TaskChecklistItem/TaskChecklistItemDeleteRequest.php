<?php

namespace App\Http\Requests\TaskChecklistItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskChecklistItemDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        $item = $this->route('item');

        return Gate::allows('delete', [$item, $task]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }
}
