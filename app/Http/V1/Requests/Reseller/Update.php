<?php

namespace App\Http\V1\Requests\Reseller;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    public const NAME = 'name';

    public const LOGO = 'logo';

    public const WEBSITE = 'website';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::NAME => 'string|required',
            self::LOGO => 'string',
            self::WEBSITE => 'string',
        ];
    }
}
