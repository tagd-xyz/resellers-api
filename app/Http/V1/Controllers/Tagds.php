<?php

namespace App\Http\V1\Controllers;

use App\Http\V1\Requests\Tagd\AvailableForResale as AvailableForResaleRequest;
use App\Http\V1\Requests\Tagd\Confirm as ConfirmRequest;
use App\Http\V1\Requests\Tagd\Index as IndexRequest;
use App\Http\V1\Requests\Tagd\Store as StoreRequest;
use App\Http\V1\Resources\Item\Tagd\Collection as TagdCollection;
use App\Http\V1\Resources\Item\Tagd\Single as TagdSingle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Tagd\Core\Models\Item\Tagd as TagdModel;
use Tagd\Core\Models\Item\TagdMeta;
use Tagd\Core\Models\Item\TagdStatus;
use Tagd\Core\Repositories\Interfaces\Actors\Consumers as ConsumersRepo;
use Tagd\Core\Repositories\Interfaces\Items\Tagds as TagdsRepo;
use Tagd\Core\Services\Interfaces\ResellerSales as ResellerSalesService;

class Tagds extends Controller
{
    /**
     * Get basic status info
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function index(
        TagdsRepo $tagdsRepo,
        IndexRequest $request
    ) {
        $actingAs = $this->actingAs($request);

        $this->authorize(
            'index',
            [TagdModel::class, $actingAs]
        );

        $tagds = $tagdsRepo->allPaginated([
            'perPage' => $request->get(IndexRequest::PER_PAGE, 25),
            'page' => $request->get(IndexRequest::PAGE, 1),
            'orderBy' => 'created_at',
            'direction' => $request->get(IndexRequest::DIRECTION, 'asc'),
            'relations' => [
                'parent',
                'parent.consumer',
                'item',
                'consumer',
                'reseller',
            ],
            'filterFunc' => function ($query) use ($actingAs) {
                $query->where('reseller_id', $actingAs->id);
            },
        ]);

        return response()->withData(
            new TagdCollection($tagds)
        );
    }

    /**
     * Get basic status info
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function availableForResale(
        TagdsRepo $tagdsRepo,
        AvailableForResaleRequest $request
    ) {
        $actingAs = $this->actingAs($request);

        $this->authorize(
            'index',
            [TagdModel::class, $actingAs]
        );

        $tagds = $tagdsRepo->allPaginated([
            'perPage' => $request->get(IndexRequest::PER_PAGE, 25),
            'page' => $request->get(IndexRequest::PAGE, 1),
            'orderBy' => 'created_at',
            'direction' => $request->get(IndexRequest::DIRECTION, 'asc'),
            'relations' => [
                'parent',
                'item',
                'consumer',
                'consumer.accessRequests',
                'reseller',
            ],
            'filterFunc' => function (Builder $query) use ($actingAs, $request) {
                $key = TagdMeta::AVAILABLE_FOR_RESALE;
                $query
                    ->where("meta->{$key->value}", true)
                    ->where('status', TagdStatus::ACTIVE)
                    ->whereHas('consumer', function (Builder $query) use ($request) {
                        $query
                            ->where('email', $request->get(AvailableForResaleRequest::CONSUMER))
                            ->whereHas('accessRequests', function (Builder $query) {
                                $query->whereNotNull('approved_at')->whereNull('rejected_at');
                            });
                    })
                    ->whereDoesntHave('children', function (Builder $query) use ($actingAs) {
                        $query
                            ->where('reseller_id', $actingAs->id)
                            ->where('status', TagdStatus::RESALE);
                    });
            },
        ]);

        return response()->withData(
            new TagdCollection($tagds)
        );
    }

    public function store(
        TagdsRepo $tagdsRepo,
        ResellerSalesService $resellerSalesService,
        StoreRequest $request
    ) {
        $actingAs = $this->actingAs($request);

        $this->authorize(
            'store',
            [TagdModel::class, $actingAs]
        );

        // TODO: validate reseller can lists the tagd

        $parentTagd = $tagdsRepo->findById(
            $request->get(StoreRequest::TAGD_ID)
        );

        $tagd = $resellerSalesService->startResellerSale(
            $actingAs,
            $parentTagd
        );

        return response()->withData(
            new TagdSingle($tagd),
            201
        );
    }

    public function show(
        Request $request,
        TagdsRepo $tagdRepo,
        string $tagdId
    ) {
        $tagd = $tagdRepo->findById($tagdId, [
            'relations' => [
                'parent',
                'item',
                'consumer',
                'reseller',
            ],
        ]);

        $this->authorize(
            'show',
            [$tagd, $this->actingAs($request)]
        );

        return response()->withData(
            new TagdSingle($tagd)
        );
    }

    public function destroy(
        Request $request,
        TagdsRepo $tagdRepo,
        string $tagdId
    ) {
        $tagd = $tagdRepo->findById($tagdId);

        $this->authorize(
            'destroy', [$tagd, $this->actingAs($request)]
        );

        $tagdRepo->deleteById($tagdId);

        return response()->withData([], 204);
    }

    public function confirm(
        ConfirmRequest $request,
        TagdsRepo $tagdRepo,
        ResellerSalesService $resellerSalesService,
        ConsumersRepo $consumersRepo,
        string $tagdId
    ) {
        $tagd = $tagdRepo->findById($tagdId);

        $this->authorize(
            'confirm', [$tagd, $this->actingAs($request)]
        );

        $consumersRepo->assertExists(
            $request->get(ConfirmRequest::CONSUMER_EMAIL)
        );

        $consumer = $consumersRepo
            ->findByEmail(
                $request->get(ConfirmRequest::CONSUMER_EMAIL
                )
            );

        $tagd = $resellerSalesService->confirmResale($tagd,
            $consumer,
            [
                'price' => $request->get(ConfirmRequest::PRICE),
            ]
        );

        return response()->withData(
            new TagdSingle($tagd)
        );
    }

    public function cancel(
        Request $request,
        TagdsRepo $tagdRepo,
        string $tagdId
    ) {
        $tagd = $tagdRepo->findById($tagdId);

        $this->authorize(
            'cancel', [$tagd, $this->actingAs($request)]
        );

        $tagd = $tagdRepo->cancel($tagd);

        return response()->withData(
            new TagdSingle($tagd)
        );
    }
}
