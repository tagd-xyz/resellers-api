<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Ref\Currencies;

use Tests\Feature\V1\Ref\Base;

class GetTest extends Base
{
    /**
     * GET /ref/currencies
     *
     * @return void
     */
    public function test_ref_currencies_get_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_REF_CURRENCIES)
            ->assertStatus(200);
    }

    public function test_ref_currencies_get_no_auth_request()
    {
        // $reseller = $this->aReseller();

        $response = $this
            ->get(static::URL_REF_CURRENCIES)
            ->assertStatus(403);
    }
}
