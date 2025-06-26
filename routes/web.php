<?php

use Illuminate\Support\Facades\Route;

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);
Route::get('/csrf-token', function () {
    return response()
        ->json(['token' => csrf_token()])
        ->withCookie(cookie('XSRF-TOKEN', csrf_token(), 60, '/', null, false, false));
});