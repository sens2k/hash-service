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
    public function getStatusTask($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }

    /**
     * Получение списка всех задач
     */
    public function getTasksList()
    {
        return new TaskCollection(Task::all());
    }

    /**
     * Создание задачи
     */
    public function createTask(CreateTaskRequest $request)
    {
        $task = Task::create(
            [
                "string" => $request->string,
                "frequency" => $request->frequency,
                "number_of_repetitions" => $request->number_of_repetitions,
                "algorithm_name" => $request->algorithm_name,
                "salt" => Task::generateSalt()
            ]
        );
        HashString::dispatch($task)->onQueue('low');
        return response()
            ->json(['status' => 'successful', 'Id of your task' => $task->id])
            ->setStatusCode(201, "Task created");
    }

    /**
     * Создание группы задач
     */
    public function createGroupOfTask(CreateGroupOfTasksRequest $requests)
    {
        $group = Group::create();
        $requests = $requests->validated();
        $tasksRequestData = $requests['tasks'];
        foreach ($tasksRequestData ?? [] as $taskData) {
            $task = Task::create(
                [
                    "string" => $taskData['string'],
                    "frequency" => $taskData['frequency'],
                    "number_of_repetitions" => $taskData['number_of_repetitions'],
                    "algorithm_name" => $taskData['algorithm_name'],
                    "salt" => Task::generateSalt()
                ]
            );
            $jobs[] = new HashString($task);
        }
        Bus::batch($jobs)
            ->onQueue('high')
            ->finally(function () use ($group) {$group->complete();})
            ->dispatch();

        return response()
            ->json(['status' => 'successful', 'Id of your task group' => $group->id])
            ->setStatusCode(201, "Group created");
    }

    /**
     * Получение статуса выполнения группы задач
     */
    public function getStatusTaskGroup($id){
        return new GroupResource(Group::findOrFail($id));
    }
}
