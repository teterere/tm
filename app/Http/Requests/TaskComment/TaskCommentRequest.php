<?php

namespace App\Http\Requests\TaskComment;

use App\Models\TaskComment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return Gate::allows('modify', $task);
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'min:1', 'max:' . TaskComment::MAX_BODY_LENGTH]
        ];
    }
}
