<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'plan'=>$this->plan,
            'offer'=>$this->offer,
            'user'=>new UserResource($this->whenloaded('user')),
        ];
    }
}
