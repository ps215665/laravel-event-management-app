<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('events', \App\Http\Controllers\Api\EventController::class)->middleware('auth:sanctum')->except(['index', 'show']);
Route::apiResource('events.attendees', \App\Http\Controllers\Api\AttendeeController::class)
    ->scoped()->except(['update']);

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');;

