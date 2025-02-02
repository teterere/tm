<?php

namespace App\Http\Requests\TaskChecklistItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskChecklistItemUpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('updateChecklistItemOrder', $task);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'items'         => ['required', 'array'],
            'items.*.id'    => ['required', 'exists:task_checklist_items,id'],
            'items.*.order' => ['required', 'integer', 'min:0']
        ];
    }
}
