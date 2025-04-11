<?php

namespace App\Http\Requests\TaskComment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TaskCommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        $comment = $this->route('comment');

        return Gate::allows('modify', $task) && Gate::allows('modify', $comment);
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'min:1', 'max:1000']
        ];
    }
}
