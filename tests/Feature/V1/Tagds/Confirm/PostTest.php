<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds\Confirm;

use Tests\Feature\V1\Tagds\Base;

class PostTest extends Base
{
    /**
     * POST /tagds/{tagd}/confirm
     *
     * @return void
     */
    public function test_tagds_confirm_post_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . $tagd->id . '/confirm', [
                'consumerEmail' => 'consumer@gmail.com',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'slug',
                ],
            ])
            ->assertJsonPath('data.status', 'active');
    }

    /**
     * POST /tagds/{tagd}/confirm
     *
     * @return void
     */
    public function test_tagds_confirm_post_missing_consumer_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . $tagd->id . '/confirm', [
                // 'consumerEmail' => 'consumer@gmail.com',
            ])
            ->assertStatus(422)
            ->assertJsonPath('error.details.consumerEmail.0', 'The consumer email field is required.');
    }

    /**
     * POST /tagds/{tagd}/confirm
     *
     * @return void
     */
    public function test_tagds_confirm_post_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            // ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . $tagd->id . '/confirm', [
                'consumerEmail' => 'consumer@gmail.com',
            ])
            ->assertStatus(403);
    }

    /**
     * POST /tagds/{tagd}/confirm
     *
     * @return void
     */
    public function test_tagds_confirm_post_not_found_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_TAGDS . '/' . '123' . '/confirm', [
                'consumerEmail' => 'consumer@gmail.com',
            ])
            ->assertStatus(404);
    }
}
