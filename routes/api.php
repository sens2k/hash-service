<?php

use App\Http\Controllers\Api\v1\TaskController;
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

Route::get('v1/tasks', [TaskController::class, 'getTasksList']); //Список всех задач

Route::get('v1/task/{id}', [TaskController::class, 'getStatusTask']); //Получения статуса выполнения задачи;

Route::post('v1/task', [TaskController::class, 'createTask']); //Создания задачи

Route::post('v1/group', [TaskController::class, 'createGroupOfTask']); //Создание группы задач

Route::get('v1/group/{id}', [TaskController::class, 'getStatusTaskGroup']); //Получение статуса выполнения группы задач
