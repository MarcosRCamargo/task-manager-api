<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TasksController;
use App\Jobs\newTaskManager as JobsNewTaskManager;
use App\Mail\newTaskManager;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
// Route::controller(TasksController::class)->group(function () {
//     Route::get('/tasks', 'index');
//     Route::get('/tasks/{id}', 'show');
//     Route::post('/tasks', 'store');
//     Route::put('task/{id}', 'update');
//     Route::delete('task/{id}', 'destroy');
// });

Route::middleware('apiJwt')->group(function () {
    // Route::post('/login', [TasksController::class, 'login']);
    Route::get('/tasks', [TasksController::class, 'index']);
    Route::get('/tasks/{id}', [TasksController::class, 'show']);
    Route::post('/tasks', [TasksController::class, 'store']);
    Route::put('task/{id}', [TasksController::class, 'update']);
    Route::delete('task/{id}', [TasksController::class, 'destroy']);
});
// Route::controller(AuthController::class)->group(function () {
//     Route::post('login', 'login');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('refresh', 'refresh');

// });

Route::group([
    'middleware' => 'api',
    ], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});
Route::post('/send-mail', function () {
    $user = new stdClass();
    $task = new stdClass();
    $user->name = "Marcos Camargo";
    $user->email = "marcos.marrize@gmail.com";
    $task->title = 'Primeira Tarefa';
    $task->description= 'Tarefa de criação de Documentação de API';
    $task->start_date= '02-25-2023 09:00:00';
    $task->end_estimate_date= '02-25-2023 09:00:00';
    $task->end_date= '02-25-2023 09:00:00';
    $task->status= 1;
    $task->owner= 1;
    $task->delegated_user= 2;
    JobsNewTaskManager::dispatch($user, $task)->delay(now()->addSeconds(10));
	// return new newTaskManager($user, $task);
});