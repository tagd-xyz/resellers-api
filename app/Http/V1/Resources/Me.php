<?php

namespace App\Http\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tagd\Core\Models\User\Role;

class Me extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $actors = $this
            ->actors()
            ->map(function ($actor) {
                return [
                    'type' => strtolower(basename(str_replace('\\', '/', get_class($actor)))),
                    'id' => $actor->id,
                    'name' => $actor->name,
                    'logoUrl' => $actor->avatar->url ?? null,
                    'logoSmallUrl' => $actor->avatar->small_url ?? null,
                    'website' => $actor->website,
                ];
            })
            ->filter(function ($actor) {
                return $actor['type'] == Role::RESELLER;
            });

        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'actors' => $actors->toArray(),
        ];
    }
}
