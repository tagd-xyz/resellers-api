<?php

namespace App\Http\V1\Requests\Tagd;

use Illuminate\Foundation\Http\FormRequest;

class Confirm extends FormRequest
{
    public const CONSUMER_EMAIL = 'consumerEmail';

    public const PRICE = 'price';

    public const PRICE_AMOUNT = 'price.amount';

    public const PRICE_CURRENCY = 'price.currency';

    public const LOCATION = 'location';

    public const LOCATION_CITY = 'location.city';

    public const LOCATION_COUNTRY = 'location.country';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            self::CONSUMER_EMAIL => 'string|required',

            self::PRICE => 'array|required',
            self::PRICE_AMOUNT => 'numeric|required',
            self::PRICE_CURRENCY => 'string|required',
        ];
    }
}
