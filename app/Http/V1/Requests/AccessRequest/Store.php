<?php

namespace App\Http\V1\Requests\AccessRequest;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public const CONSUMER = 'consumer';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::CONSUMER => 'string|email|required',
        ];
    }
}
