<?php
/**
 * Created by frkn.
 * User: Furkan İKİZ
 * Date: 11.11.2019
 * Time: 23:16
 */

namespace App\Services;


use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskCollectionResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepo;

class TaskService
{
    private $taskRepo;

    public function __construct(TaskRepo $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function getAllTask(): TaskCollectionResource
    {
        return new TaskCollectionResource($this->taskRepo->getAll());
    }

    public function storeTask(TaskStoreRequest $request): TaskResource
    {
        $request->validated();
        $task = $this->fillTask($request, new Task());
        $task->save();

        return new TaskResource($task);
    }

    public function updateTask(TaskStoreRequest $request, int $id)
    {
        $request->validated();
        $task = $this->fillTask($request, $this->taskRepo->findOrFailTaskById($id));
        $task->save();

        return new TaskResource($task);
    }

    public function deleteTask(int $id): TaskCollectionResource
    {
        $task = $this->taskRepo->findOrFailTaskById($id);
        $task->delete();

        return new TaskCollectionResource(collect($task));
    }

    public function getTask(int $id): TaskResource
    {
        return new TaskResource($this->taskRepo->findOrFailTaskById($id));
    }

    private function fillTask(TaskStoreRequest $request, Task $task): Task
    {
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->status = $request['status'];
        $task->user_id = $request['user_id'];

        return $task;
    }
}
