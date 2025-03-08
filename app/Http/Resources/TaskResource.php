<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                              => $this->id,
            'assignee'                        => $this->whenLoaded('assignee', function () {
                return EmployeeResource::make($this->assignee);
            }),
            'priority'                        => $this->whenLoaded('priority'),
            'status'                          => $this->whenLoaded('status'),
            'labels'                          => $this->whenLoaded('labels'),
            'checklist_items'                 => $this->whenLoaded('checklistItems')->values(),
            'order'                           => $this->order,
            'identifier'                      => $this->identifier,
            'completed_checklist_items_count' => $this->completedChecklistItemsCount,
            'title'                           => $this->title,
            'description'                     => $this->description,
            'due_date_raw'                    => $this->due_date,
            'due_date'                        => $this->due_date->locale('lv')->translatedFormat('j. F'),
            'estimate_raw'                    => $this->estimate,
            'estimate'                        => $this->formattedEstimate,
            'created_at'                      => $this->created_at->diffForHumans(),
        ];
    }
}
