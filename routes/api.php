<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api/1.0')->group(function () {
    Route::get('/skeleton-api', function () {
        return response()->json(['message' => 'Skeleton API']);
    });
});