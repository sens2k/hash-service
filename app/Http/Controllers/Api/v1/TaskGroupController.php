<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGroupOfTasksRequest;
use App\Models\Task;
use App\Models\Group;
use App\Jobs\HashString;
use App\Http\Resources\GroupResource;
use Illuminate\Support\Facades\Bus;
use App\Services\HashService;

class TaskGroupController extends Controller
{
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
                    "salt" => HashService::generateSalt(),
                    "group_id" => $group->id,
                ]
            );
            $jobs[] = new HashString($task);
        }
        /* Добавление созданного массива задач в очередь с высоким(high) приоритетом */
        $batch = Bus::batch($jobs)
            ->onQueue('high')
            ->finally(function () use ($group) {$group->setStatusComplete();})
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
     * Отмена группы задач
     */
    public function stopTaskGroup($id){
        return response()->json(['status' => 'This method is under development']);
    }
}
