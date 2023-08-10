<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\App\Http\V1\Controllers')->group(function () {
    Route::permanentRedirect('/', '/api/v1/status');

    Route::middleware('guest')->group(function () {
        Route::get('status', 'Status@index')
            ->name('status');
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::get('me', 'Me@show');

        Route::resource('resellers', 'Resellers')->only([
            'update',
        ]);

        Route::resource('resellers.uploads', 'ResellersUploads')->only([
            'store',
        ]);

        Route::resource('tagds', 'Tagds')->only([
            'index', 'store', 'show', 'destroy',
        ]);
        Route::post('tagds/{id}/confirm', 'Tagds@confirm');
        Route::post('tagds/{id}/cancel', 'Tagds@cancel');

        Route::get('tagds-available-for-resale', 'Tagds@availableForResale');

        Route::resource('resale-access-requests', 'ResaleAccessRequests')->only([
            'index', 'store', //'show', 'destroy',
        ]);

        Route::group(['namespace' => 'Ref'], function () {
            Route::prefix('ref')->group(function () {
                Route::resource('currencies', 'Currencies')->only([
                    'index',
                ]);
            });
        });
    });
});
