<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('profiles', App\Http\Controllers\ProfileController::class);

Route::resource('posts', App\Http\Controllers\PostController::class);

Route::post('/{id}/addfriend/{user}', [App\Http\Controllers\FriendController::class, 'store']);
Route::get('/{id}/status/{user}', [App\Http\Controllers\FriendController::class, 'status']);
