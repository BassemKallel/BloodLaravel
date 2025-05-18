<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CentreController;
use App\Http\Controllers\Api\RendezvousController;

Route::apiResource('centres', CentreController::class);
Route::apiResource('rendezvous', RendezvousController::class);
Route::apiResource('users', UserController::class);


