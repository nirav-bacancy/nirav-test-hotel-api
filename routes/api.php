<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;

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
// route for fetch all active hotels data
Route::get('hotels', [HotelController::class,'getAllHotelData']);

// route for fetch the active hotel data based on hotel id
Route::get('hotel/{hotel_id}', [HotelController::class,'getHotelDataById']);