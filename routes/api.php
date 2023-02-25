<?php

use App\Http\Controllers\TasksController;
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

Route::get('/', function () {
	return 'Task API';
});
Route::controller(TasksController::class)->group(function () {
    Route::get('/tasks', 'index');
    Route::get('/tasks/{id}', 'show');
    Route::post('/tasks', 'store');
    Route::put('task/{id}', 'update');
    Route::delete('task/{id}', 'destroy');
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });