<?php

namespace App\Http\V1\Controllers;

use App\Http\V1\Requests\Reseller\Update as UpdateRequest;
use App\Http\V1\Resources\Actor\Reseller\Single as ResellerSingle;
use Tagd\Core\Repositories\Interfaces\Actors\Resellers as ResellersRepo;

class Resellers extends Controller
{
    public function update(
        UpdateRequest $request,
        ResellersRepo $resellersRepo,
        string $resellerId
    ) {
        $reseller = $resellersRepo->findById($resellerId);

        $this->authorize(
            'update',
            [$reseller, $this->actingAs($request)]
        );

        $reseller = $resellersRepo->update($resellerId, [
            'name' => $request->get(UpdateRequest::NAME),
            'avatar_upload_id' => $request->get(UpdateRequest::AVATAR_UPLOAD_ID),
            'website' => $request->get(UpdateRequest::WEBSITE),
        ]);

        return response()->withData(
            new ResellerSingle($reseller)
        );
    }
}
