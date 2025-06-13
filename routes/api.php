<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    return response()->json([
        'token' => $request->user()->createToken('api-token')->plainTextToken
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [Api\ProductController::class, 'index']);
    Route::post('/sales-orders', [Api\SalesOrderController::class, 'store']);
    Route::get('/sales-orders/{id}', [Api\SalesOrderController::class, 'show']);
});