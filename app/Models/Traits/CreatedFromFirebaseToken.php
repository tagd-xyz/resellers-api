<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait CreatedFromFirebaseToken
{
    public static function createFromFirebaseToken(object $payload): static
    {
        return DB::transaction(function () use ($payload) {
            $self = static::firstOrCreate([
                'firebase_id' => $payload->user_id,
            ]);

            if ($self->wasRecentlyCreated === true) {
                $self->email = $payload->email;
                $self->name = $payload->name;
                $self->save();
            }

            return $self;
        }, 5);
    }
}
