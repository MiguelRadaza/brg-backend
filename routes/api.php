<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\NotebookController;

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


Route::post('/auth/login', [AuthenticationController::class, 'loginUser']);
Route::post('/auth/register', [AuthenticationController::class, 'createUser']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/auth/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/auth/logout', [AuthenticationController::class, 'logoutUser']);
    
    // Notebook
    Route::prefix('notebook')->group(function () {
        Route::post('/create', [NotebookController::class, 'create']);
        Route::post('/update', [NotebookController::class, 'update']);
        Route::post('/', [NotebookController::class, 'getNotes']);
    });
});