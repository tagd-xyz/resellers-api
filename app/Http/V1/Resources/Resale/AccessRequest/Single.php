<?php

namespace App\Http\V1\Resources\Resale\AccessRequest;

use App\Http\V1\Resources\Actor\Consumer\Single as ConsumerSingle;
use Illuminate\Http\Resources\Json\JsonResource;

class Single extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'isPending' => $this->is_pending,
            'isApproved' => $this->is_approved,
            'isRevoked' => $this->is_revoked,
            'isRejected' => $this->is_rejected,
            'createdAt' => $this->created_at,
            'approvedAt' => $this->approved_at,
            'rejectedAt' => $this->rejected_at,
            'consumer' => new ConsumerSingle($this->whenLoaded('consumer')),
        ];
    }
}
