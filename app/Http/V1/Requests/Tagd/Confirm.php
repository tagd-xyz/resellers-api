<?php

namespace App\Http\V1\Requests\Tagd;

use Illuminate\Foundation\Http\FormRequest;

class Confirm extends FormRequest
{
    public const CONSUMER_EMAIL = 'consumerEmail';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::CONSUMER_EMAIL => 'string|required',
        ];
    }
}
