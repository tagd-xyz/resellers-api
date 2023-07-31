<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds;

class GetAllTest extends Base
{
    /**
     * GET /tagds
     *
     * @return void
     */
    public function test_tagds_get_all_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                    ],
                ],
            ]);
    }

    /**
     * GET /tagds
     *
     * @return void
     */
    public function test_tagds_get_all_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            // ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS)
            ->assertStatus(403);
    }
}
