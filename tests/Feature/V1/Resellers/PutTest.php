<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Resellers;

class PutTest extends Base
{
    /**
     * PUT /resellers/{resellerd}
     *
     * @return void
     */
    public function test_resellers_put_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->put(static::URL_RESELLERS . '/' . $reseller->id, [
                'name' => 'New Name',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'name',
                ],
            ])
            ->assertJsonPath('data.name', 'New Name');
    }

    /**
     * PUT /resellers/{resellerd}
     *
     * @return void
     */
    public function test_resellers_put_not_auth_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            // ->actingAsAReseller($reseller)
            ->put(static::URL_RESELLERS . '/' . $reseller->id, [
                'name' => 'New Name',
            ])
            ->assertStatus(403);
    }

    /**
     * PUT /resellers/{resellerd}
     *
     * @return void
     */
    public function test_resellers_put_not_found_request()
    {
        $reseller = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->put(static::URL_RESELLERS . '/' . '123', [
                'name' => 'New Name',
            ])
            ->assertStatus(404);
    }

    /**
     * PUT /resellers/{resellerd}
     *
     * @return void
     */
    public function test_resellers_put_not_allow_request()
    {
        $reseller = $this->aReseller();

        $reseller2 = $this->aReseller();

        $response = $this
            ->actingAsAReseller($reseller)
            ->put(static::URL_RESELLERS . '/' . $reseller2->id, [
                'name' => 'New Name',
            ])
            ->assertStatus(403);
    }
}
