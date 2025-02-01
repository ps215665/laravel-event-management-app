<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('events', \App\Http\Controllers\Api\EventController::class);
Route::apiResource('events.attendees', \App\Http\Controllers\Api\AttendeeController::class)
    ->scoped(['attendee' => 'event']);

