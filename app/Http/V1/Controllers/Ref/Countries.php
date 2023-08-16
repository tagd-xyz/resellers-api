<?php

namespace App\Http\V1\Controllers\Ref;

use App\Http\V1\Controllers\Controller;
use App\Http\V1\Resources\Ref\Country\Collection as CountryCollection;
use Illuminate\Http\Request;
use Tagd\Core\Models\Ref\Country;

class Countries extends Controller
{
    public function index(
        Request $request
    ) {
        return response()->withData(
            new CountryCollection(Country::all())
        );
    }
}
