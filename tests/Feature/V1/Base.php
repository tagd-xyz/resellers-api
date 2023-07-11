<?php

namespace Tests\Feature\V1;

use Illuminate\Support\Facades\Notification;
use Tagd\Core\Database\Seeders\Traits\UsesFactories;
use Tests\TestCase;

abstract class Base extends TestCase
{
    use UsesFactories;

    public const URL_V1 = '/api/v1';

    public const URL_STATUS = '/api/v1/status';

    public const URL_ME = '/api/v1/me';

    public const URL_RESELLERS = 'api/v1/resellers';

    public const URL_RESALE_ACCESS_REQUESTS = '/api/v1/resale-access-requests';

    public const URL_TAGDS = '/api/v1/tagds';

    public const URL_TAGDS_AVAILABLE_FOR_RESALE = '/api/v1/tagds-available-for-resale';

    /**
     * setUp any test
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept' => 'application/json',
        ]);

        Notification::fake();

        $this->setupFactories();
    }
}
