<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsaltantProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'technical'=>$this->technical,
            'plan'=>$this->plan,
            'table'=>$this->table,
            'user'=>new UserResource($this->whenloaded('user'))
        ];
    }
}
