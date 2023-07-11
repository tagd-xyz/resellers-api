<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\TagdsAvailableForResale;

use Tagd\Core\Models\Resale\AccessRequest;

class GetTest extends Base
{
    /**
     * GET /tagds/available-for-resale
     *
     * @return void
     */
    public function test_tagds_available_get_request()
    {
        $reseller = $this->aReseller();
        $consumer = $this->aConsumer();

        $tagd = $this->aTagd([
            'consumer' => $consumer,
        ]);
        $tagd->activate();
        $tagd->enableForResale();
        $tagd->save();

        $accessRequest = AccessRequest::factory()
            ->for($reseller)
            ->for($consumer)
            ->create();
        $accessRequest->approve();

        $response = $this
            ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS_AVAILABLE_FOR_RESALE . '?consumer=' . $consumer->email)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                    ],
                ],
            ])
            ->assertJsonPath('data.0.id', $tagd->id);
    }

    /**
     * GET /tagds/available-for-resale
     *
     * @return void
     */
    public function test_tagds_available_get_not_auth_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            // ->actingAsAReseller($reseller)
            ->get(static::URL_TAGDS_AVAILABLE_FOR_RESALE . '?consumer=' . 'a@a.com')
            ->assertStatus(403);
    }
}
