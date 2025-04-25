<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $commentDirection = $request->get('commentDirection', 'desc');

        return [
            'id'                              => $this->id,
            'assignee'                        => $this->whenLoaded('assignee', fn() => EmployeeResource::make($this->assignee)),
            'priority'                        => $this->whenLoaded('priority'),
            'status'                          => $this->whenLoaded('status'),
            'labels'                          => $this->whenLoaded('labels'),
            'checklist_items'                 => $this->whenLoaded('checklistItems', fn() => $this->checklistItems->values()),
            'comments' => $this->whenLoaded('comments', function () use ($commentDirection) {
                $paginatedComments = $this->comments()
                    ->orderBy('created_at', $commentDirection)
                    ->paginate(5, ['*'], 'komentari');

                return (new PaginatedResourceResponse(
                    TaskCommentResource::collection($paginatedComments)
                ))->toResponse(request())->getData();
            }),
            'order'                           => $this->order,
            'identifier'                      => $this->identifier,
            'completed_checklist_items_count' => $this->completedChecklistItemsCount,
            'title'                           => $this->title,
            'description'                     => $this->description,
            'due_date_raw'                    => $this->due_date,
            'due_date'                        => optional($this->due_date)->locale('lv')->translatedFormat('j. F'),
            'estimate_raw'                    => $this->estimate,
            'estimate'                        => $this->formattedEstimate,
            'created_at'                      => $this->created_at->locale('lv')->diffForHumans(),
        ];
    }
}
