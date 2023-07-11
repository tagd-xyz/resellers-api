<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds;

class PostTest extends Base
{
    /**
     * POST /tagds
     *
     * @return void
     */
    public function test_tagds_post_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aTagd();

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS, [
                'tagdId' => $tagd->id,
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'slug',
                ],
            ]);
    }

    /**
     * POST /tagds
     *
     * @return void
     */
    public function test_tagds_post_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aTagd();

        $response = $this
            // ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS, [
                'tagdId' => $tagd->id,
            ])
            ->assertStatus(403);
    }
}
