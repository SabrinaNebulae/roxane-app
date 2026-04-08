<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->name,
            'description' => $this->description,
            'url' => $this->url,
            'icon' => $this->icon,
            'is_active' => (bool) $this->whenPivotLoaded('services_memberships', fn () => $this->pivot->is_active),
        ];
    }
}
