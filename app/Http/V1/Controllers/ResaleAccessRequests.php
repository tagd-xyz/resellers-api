<?php

namespace App\Http\V1\Controllers;

// use App\Http\V1\Requests\Item\Index as IndexRequest;
use App\Http\V1\Requests\AccessRequest\Store as StoreRequest;
use App\Http\V1\Resources\Resale\AccessRequest\Collection as AccessRequestCollection;
use App\Http\V1\Resources\Resale\AccessRequest\Single as AccessRequestSingle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Tagd\Core\Models\Resale\AccessRequest;
use Tagd\Core\Repositories\Interfaces\Actors\Consumers as ConsumersRepo;
use Tagd\Core\Repositories\Interfaces\Resales\AccessRequests as AccessRequestsRepo;

class ResaleAccessRequests extends Controller
{
    /**
     * Get basic status info
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index(
        Request $request,
        AccessRequestsRepo $accessRequestsRepo,
    ) {
        $actingAs = $this->actingAs($request);

        $this->authorize(
            'index',
            [AccessRequest::class, $actingAs]
        );

        $accessRequests = $accessRequestsRepo->all([
            'orderBy' => 'created_at',
            'relations' => [
                'consumer',
            ],
            'filterFunc' => function (Builder $query) use ($actingAs) {
                $query->where('reseller_id', $actingAs->id);
            },
        ]);

        return response()->withData(
            new AccessRequestCollection($accessRequests)
        );
    }

    public function store(
        AccessRequestsRepo $accessRequestsRepo,
        ConsumersRepo $consumersRepo,
        StoreRequest $request
    ) {
        $actingAs = $this->actingAs($request);

        $this->authorize(
            'store',
            [AccessRequest::class, $actingAs]
        );

        $consumer = $consumersRepo->findByEmail(
            $request->get(StoreRequest::CONSUMER)
        );

        $accessRequest = $accessRequestsRepo
            ->create([
                'consumer_id' => $consumer->id,
                'reseller_id' => $actingAs->id,
            ]);

        return response()->withData(
            new AccessRequestSingle($accessRequest),
            201
        );
    }

    // public function show(
    //     Request $request,
    //     ItemsRepo $itemsRepo,
    //     string $itemId
    // ) {
    //     $item = $itemsRepo->findById($itemId, [
    //         'relations' => [
    //             'retailer',
    //             'tagds',
    //             'tagds.consumer',
    //             'tagds.reseller',
    //         ],
    //     ]);

    //     $this->authorize(
    //         'show',
    //         [$item, $this->actingAs($request)]
    //     );

    //     return response()->withData(
    //         new ItemSingle($item)
    //     );
    // }

    // public function destroy(
    //     Request $request,
    //     ItemsRepo $itemsRepo,
    //     string $itemId
    // ) {
    //     $item = $itemsRepo->deleteById($itemId);

    //     $this->authorize(
    //         'destroy', [$item, $this->actingAs($request)]
    //     );

    //     return response()->withData([]);
    // }
}
