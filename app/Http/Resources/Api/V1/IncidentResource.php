<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ref_user' => $this->ref_user,
            'ref_category' => $this->ref_category,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'value' => $this->value,
            'active' => $this->is_active,
            'dt_register' => $this->dt_register
        ];
    }
}
