<?php

namespace App\Http\Requests\TaskLabels;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AddLabelsRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        if (!Gate::allows('modify', $task)) {
            return false;
        }

        // Check if label belongs to the same company as task
        foreach ($this->get('selectedLabels', []) as $label) {
            if (isset($label['company_id']) && $label['company_id'] !== $task->company_id) {
                return false;
            }
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'selectedLabels'         => ['required', 'array'],
            'selectedLabels.*.id'    => ['nullable', 'integer', 'exists:task_labels,id'],
            'selectedLabels.*.title' => ['required_without:selectedLabels.*.id', 'string', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'selectedLabels.required'                 => 'Jānorāda vismaz viena birka.',
            'selectedLabels.*.id.integer'             => 'Birkas ID ir jābūt veselam skaitlim.',
            'selectedLabels.*.id.exists'              => 'Izvēlētā birka neeksistē.',
            'selectedLabels.*.title.required_without' => 'Nosaukums nedrīkst būt tukšs',
            'selectedLabels.*.title.max'              => 'Nosaukums nedrīkst būt garāks par 255 rakstzīmēm'
        ];
    }
}
