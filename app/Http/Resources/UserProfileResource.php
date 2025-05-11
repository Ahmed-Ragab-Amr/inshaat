<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{

    protected $mainPayment;

    public function __construct($resource, $mainPayment = null)
    {
        parent::__construct($resource);
        $this->mainPayment = $mainPayment;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'image'=>$this->image,
            'name'=>$this->name,
            'phone'=>$this->phone,
            'address'=>$this->image,
            'email'=>$this->email,
            'main_payment' => $this->mainPayment ? new PaymentResource($this->mainPayment) : null,
            'payments'=>PaymentResource::collection($this->whenloaded('payments')),
        ];
    }
}
