<?php

//phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Tests\Feature\V1\ResaleAccessRequests;

use Tagd\Core\Tests\Traits\NeedsConsumers;
use Tagd\Core\Tests\Traits\NeedsDatabase;
use Tagd\Core\Tests\Traits\NeedsResales;
use Tagd\Core\Tests\Traits\NeedsResellers;
use Tagd\Core\Tests\Traits\NeedsTagds;

abstract class Base extends \Tests\Feature\V1\Base
{
    use NeedsDatabase, NeedsResales, NeedsResellers, NeedsConsumers, NeedsTagds;
}
