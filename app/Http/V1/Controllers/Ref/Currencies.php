<?php

namespace App\Http\V1\Controllers\Ref;

use App\Http\V1\Controllers\Controller;
use App\Http\V1\Resources\Ref\Currency\Collection as CurrencyCollection;
use Illuminate\Http\Request;
use Tagd\Core\Models\Ref\Currency;

class Currencies extends Controller
{
    public function index(
        Request $request
    ) {
        return response()->withData(
            new CurrencyCollection(Currency::all())
        );
    }
}
