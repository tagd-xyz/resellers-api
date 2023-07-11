<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\ResaleAccessRequests;

use Tagd\Core\Models\Resale\AccessRequest;

class GetTest extends Base
{
    /**
     * GET /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_get_request()
    {
        $reseller = $this->aReseller();
        $consumer = $this->aConsumer();

        $accessRequest = AccessRequest::factory()
            ->for($reseller)
            ->for($consumer)
            ->create();

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_RESALE_ACCESS_REQUESTS)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                    ],
                ],
            ])
            ->assertJsonPath('data.0.consumer.email', $consumer->email);
    }

    /**
     * GET /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_get_not_auth_request()
    {
        $reseller = $this->aReseller();
        $consumer = $this->aConsumer();

        $accessRequest = AccessRequest::factory()
            ->for($reseller)
            ->for($consumer)
            ->create();

        $response = $this
            // ->actingAsAReseller($reseller)
            ->get(static::URL_RESALE_ACCESS_REQUESTS)
            ->assertStatus(403);
    }

    /**
     * GET /tagds/resale-access-requests
     *
     * @return void
     */
    public function test_resale_access_requests_get_not_allowed_request()
    {
        $reseller = $this->aReseller();
        $reseller2 = $this->aReseller();
        $consumer = $this->aConsumer();

        $accessRequest = AccessRequest::factory()
            ->for($reseller2)
            ->for($consumer)
            ->create();

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_RESALE_ACCESS_REQUESTS)
            ->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }
}
