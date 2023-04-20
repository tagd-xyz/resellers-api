<?php

namespace App\Http\V1\Controllers;

use App\Http\V1\Requests\AvatarRequest\Store as StoreRequest;
use App\Http\V1\Resources\Upload\Single as UploadSingle;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Tagd\Core\Repositories\Interfaces\Actors\Resellers as ResellersRepo;
use Tagd\Core\Repositories\Interfaces\Uploads\Resellers as ResellersUploadsRepo;

class ResellersUploads extends BaseController
{
    /**
     * Get basic status info
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function store(
        ResellersRepo $resellersRepo,
        ResellersUploadsRepo $uploadsRepo,
        string $resellerId,
        StoreRequest $request
    ) {
        $user = Auth::user();

        //auth

        $reseller = $resellersRepo->findById($resellerId);

        $upload = $uploadsRepo->avatar(
            $reseller->id,
            $request->get(StoreRequest::FILE_NAME)
        );

        return response()->withData(
            new UploadSingle($upload),
            201
        );
    }
}
