<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskCommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'task_id'    => $this->task_id,
            'author'     => EmployeeResource::make($this->author),
            'body'       => $this->body,
            'created_at' => $this->created_at->locale('lv')->diffForHumans()
        ];
    }
}
