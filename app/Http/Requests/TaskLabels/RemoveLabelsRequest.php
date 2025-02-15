<?php

namespace App\Http\Requests\TaskLabels;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class RemoveLabelsRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('modify', $task);
    }

    public function rules(): array
    {
        return [];
    }
}
