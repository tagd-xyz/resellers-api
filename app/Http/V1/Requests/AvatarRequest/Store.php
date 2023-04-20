<?php

namespace App\Http\V1\Requests\AvatarRequest;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    public const FILE_NAME = 'fileName';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::FILE_NAME => 'required|string',
        ];
    }
}
