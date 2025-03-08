<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskCommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'task_id' => $this->task_id,
            'author'  => $this->whenLoaded('author', function () {
                return EmployeeResource::make($this->assignee);
            }),
            'body'    => $this->body
        ];
    }
}
