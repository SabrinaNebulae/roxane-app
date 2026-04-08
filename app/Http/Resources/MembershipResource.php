<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'amount' => $this->amount,
            'package' => new PackageResource($this->whenLoaded('package')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
