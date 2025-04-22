<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'avatar_path' => $this->avatar ? asset('storage/uploads/avatars/' . $this->avatar) : 'https://ui-avatars.com/api/?name=' . $this->name,
            'is_auth'     => $this->id === auth()?->id()
        ];
    }
}
