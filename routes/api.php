<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/voice', [VoiceController::class, 'voiceOutput']);
Route::post('/chat', [VoiceController::class, 'speechtoText']);
Route::post('/endCall', [VoiceController::class, 'endCall']);
Route::post('/makeCall', [VoiceController::class, 'makeCall']);
