<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupOfTasksRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Jobs\HashString;
use App\Models\Group;
use App\Models\Task;
use Illuminate\Support\Facades\Bus;
use function response;


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
                "salt" => Task::generateSalt()
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
     * Создание группы задач
     */
    public function createTaskGroup(CreateGroupOfTasksRequest $requests){
        /* Создание новой группы задач */
        $group = Group::create();

        /* Формирование массива задач */
        $tasksRequestData = $requests['tasks'];
        foreach ($tasksRequestData ?? [] as $taskData) {
            $task = Task::create(
                [
                    "string" => $taskData['string'],
                    "frequency" => $taskData['frequency'],
                    "number_of_repetitions" => $taskData['number_of_repetitions'],
                    "algorithm_name" => $taskData['algorithm_name'],
                    "salt" => Task::generateSalt(),
                    "group_id" => $group->id,
                ]
            );
            $jobs[] = new HashString($task);
        }
        /* Добавление созданного массива задач в очередь с высоким(high) приоритетом */
        $batch = Bus::batch($jobs)
            ->onQueue('high')
            ->finally(function () use ($group) {$group->execute();})
            ->dispatch();

        /* Добавление новой группе id пакета */
        $group->setBatchId($batch->id);

        /* Возвращение ответа от сервера со статусом 201 */
        return response()
            ->json(['status' => 'successful', 'Id of your task group' => $group->id, 'Batch id' => $group->batch_id])
            ->setStatusCode(201, "Group created");
    }

    /**
     * Получение статуса выполнения группы задач
     */
    public function getStatusTaskGroup($id){
        return new GroupResource(Group::findOrFail($id));
    }

    /**
     * Отмена задачи
     */
    public function stopTask($id){
        return response()->json(['status' => 'This method is under development']);
    }

    /**
     * Отмена группы задач
     */
    public function stopTaskGroup($id){
        return response()->json(['status' => 'This method is under development']);
    }
}
