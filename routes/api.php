<?php

use Illuminate\Support\Facades\Route;
use KirschbaumDevelopment\NovaMail\Http\Controllers\MailController;
use KirschbaumDevelopment\NovaMail\Http\Controllers\SendMailController;
use KirschbaumDevelopment\NovaMail\Http\Controllers\TemplatesController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. You're free` to add
| as many additional routes to this file as your tool may require.
|
*/

Route::get('/templates', TemplatesController::class);
Route::get('/mail/{mail}', MailController::class);
Route::post('/send/{mailTemplate?}', SendMailController::class);
