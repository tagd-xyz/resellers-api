<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\ResaleAccessRequests;

class PostTest extends Base
{
    /**
     * POST /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_post_request()
    {
        $reseller = $this->aReseller();
        $consumer = $this->aConsumer();

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_RESALE_ACCESS_REQUESTS, [
                'consumer' => $consumer->email,
            ])
            ->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                ],
            ])
            ->assertJsonPath('data.consumer.email', $consumer->email);
    }

    /**
     * POST /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_post_not_auth_request()
    {
        $reseller = $this->aReseller();
        $consumer = $this->aConsumer();

        $response = $this
            // ->actingAsAReseller($reseller)
            ->post(static::URL_RESALE_ACCESS_REQUESTS, [
                'consumer' => $consumer->email,
            ])
            ->assertStatus(403);
    }

    /**
     * POST /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_post_not_found_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->post(static::URL_RESALE_ACCESS_REQUESTS, [
                'consumer' => 'a@a.com',
            ])
            ->assertStatus(404);
    }
}
