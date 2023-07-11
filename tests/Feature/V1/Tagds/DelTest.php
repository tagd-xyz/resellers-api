<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\Tagds;

class DelTest extends Base
{
    /**
     * DEL /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_del_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->delete(static::URL_TAGDS . '/' . $tagd->id)
            ->assertStatus(204);
    }

    /**
     * DEL /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_del_not_auth_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            // ->actingAsAReseller($reseller)
            ->delete(static::URL_TAGDS . '/' . $tagd->id)
            ->assertStatus(403);
    }

    /**
     * DEL /tagds/{tagdId}
     *
     * @return void
     */
    public function test_tagds_del_not_found_request()
    {
        $reseller = $this->aReseller();

        $tagd = $this->aResale([
            'reseller' => $reseller,
        ]);

        $response = $this
            ->actingAsAReseller($reseller)
            ->delete(static::URL_TAGDS . '/' . '123')
            ->assertStatus(404);
    }
}
