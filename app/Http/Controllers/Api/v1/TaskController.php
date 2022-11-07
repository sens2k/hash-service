<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Jobs\HashString;
use App\Models\Task;
use function response;
use App\Services\HashService;


class TaskController extends Controller
{
    /**
     * Получение статуса выполнения задачи
     */
    public function getStatusTask($id){
        return new TaskResource(Task::findOrFail($id));
    }

    /**
     * Получение списка всех задач
     */
    public function getTasksList(){
        return new TaskCollection(Task::all());
    }

    /**
     * Создание задачи
     */
    public function createTask(CreateTaskRequest $request){
        /* Создание новой задачи */
        $task = Task::create(
            [
                "string" => $request->string,
                "frequency" => $request->frequency,
                "number_of_repetitions" => $request->number_of_repetitions,
                "algorithm_name" => $request->algorithm_name,
                "salt" => HashService::generateSalt()
            ]
        );

        /*  Создание новой job и добавление туда новой задачи,
        с последующем добавлением job в очеред с низким(low) приоритетом  */
        HashString::dispatch($task)->onQueue('low');

        /* Возвращение ответа от сервера со статусом 201 */
        return response()
            ->json(['status' => 'successful', 'Id of your task' => $task->id])
            ->setStatusCode(201, "Task created");
    }

    /**
     * Отмена задачи
     */
    public function stopTask($id){
        return response()->json(['status' => 'This method is under development']);
    }
}
