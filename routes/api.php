<?php

use App\Http\Controllers\Api\v1\TaskController;
use App\Http\Controllers\Api\v1\TaskGroupController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//API

//task
Route::get('v1/tasks', [TaskController::class, 'getTasksList']); //Список всех задач

Route::get('v1/task/{id}', [TaskController::class, 'getStatusTask']); //Получения статуса выполнения задачи;

Route::post('v1/task', [TaskController::class, 'createTask']); //Создания задачи

Route::get('v1/task/stop/{id}', [TaskController::class, 'stopTask']); //Остановка задачи

//group
Route::post('v1/group', [TaskGroupController::class, 'createTaskGroup']); //Создание группы задач

Route::get('v1/group/{id}', [TaskGroupController::class, 'getStatusTaskGroup']); //Получение статуса выполнения группы задач

Route::get('v1/group/stop/{id}', [TaskGroupController::class, 'stopTaskGroup']); //Остановка группы задач
