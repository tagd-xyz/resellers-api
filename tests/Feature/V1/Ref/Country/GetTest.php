<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Ref\Countries;

use Tests\Feature\V1\Ref\Base;

class GetTest extends Base
{
    /**
     * GET /ref/countries
     *
     * @return void
     */
    public function test_ref_countries_get_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_REF_COUNTRIES)
            ->assertStatus(200);
    }

    public function test_ref_countries_get_no_auth_request()
    {
        // $reseller = $this->aReseller();

        $response = $this
            ->get(static::URL_REF_COUNTRIES)
            ->assertStatus(403);
    }
}
