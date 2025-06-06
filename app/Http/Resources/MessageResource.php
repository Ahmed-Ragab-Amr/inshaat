<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'conversation_id'=>$this->conversation_id,
            'message'=>$this->content,
            'sender'=>new UserResource($this->whenloaded('sender')),
        ];
    }
}
