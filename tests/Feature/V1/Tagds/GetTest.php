<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds;

class GetTest extends Base
{
    /**
     * GET /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_get_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS . '/' . $tagd->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'slug',
                ],
            ]);
    }

    /**
     * GET /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_get_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            // ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS . '/' . $tagd->id)
            ->assertStatus(403);
    }

    /**
     * GET /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_get_not_allow_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            // 'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS . '/' . $tagd->id)
            ->assertStatus(403);
    }

    /**
     * GET /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_get_not_found_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS . '/' . '123')
            ->assertStatus(404);
    }
}
