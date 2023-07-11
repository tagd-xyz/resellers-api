<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds\Cancel;

use Tests\Feature\V1\Tagds\Base;

class PostTest extends Base
{
    /**
     * POST /tagds/{tagd}/cancel
     *
     * @return void
     */
    public function test_tagds_cancel_post_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . $tagd->id . '/cancel')
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'slug',
                ],
            ])
            ->assertJsonPath('data.status', 'cancelled');
    }

    /**
     * POST /tagds/{tagd}/cancel
     *
     * @return void
     */
    public function test_tagds_cancel_post_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            // ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . $tagd->id . '/cancel')
            ->assertStatus(403);
    }

    /**
     * POST /tagds/{tagd}/cancel
     *
     * @return void
     */
    public function test_tagds_cancel_post_not_found_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . '123' . '/cancel')
            ->assertStatus(404);
    }
}
