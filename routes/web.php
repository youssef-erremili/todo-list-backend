<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', function () {
    return view('welcome');
});

// Broadcast routes for authentication
Broadcast::routes(['middleware' => ['auth:api']]);