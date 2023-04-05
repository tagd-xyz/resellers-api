<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait CreatedFromFirebaseToken
{
    public static function createFromFirebaseToken(object $payload): static
    {
        return DB::transaction(function () use ($payload) {
            return static::firstOrCreate([
                'firebase_id' => $payload->user_id,
                'email' => $payload->email,
            ], [
                'name' => $payload->name ?? $payload->email,
            ]);
        }, 5);
    }
}
