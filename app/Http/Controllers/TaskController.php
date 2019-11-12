<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskCollectionResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return TaskCollectionResource
     */
    public function index()
    {
        return new TaskCollectionResource(Task::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     *
     * @return TaskResource
     */
    public function store(TaskStoreRequest $request)
    {
        $request->validated();
        $task = $this->fillTask($request, new Task());
        $task->save();

        return new TaskResource($task);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return TaskResource
     */
    public function show($id)
    {
        return new TaskResource($this->getTaskById($id));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param TaskStoreRequest $request
     * @param int $id
     *
     * @return TaskResource
     */
    public function update(TaskStoreRequest $request, $id)
    {
        $request->validated();
        $task = $this->fillTask($request, $this->getTaskById($id));
        $task->save();

        return new TaskResource($task);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return TaskCollectionResource
     */
    public function destroy($id)
    {
        $task = $this->getTaskById($id);
        $task->delete();

        return new TaskCollectionResource(collect($task));
    }


    private function getTaskById($id)
    {
        return Task::findOrFail($id);
    }


    /**
     * @param TaskStoreRequest $request
     * @param Task $task
     *
     * @return Task
     */
    private function fillTask(TaskStoreRequest $request, Task $task)
    {
        $task->title = $request['title'];
        $task->description = $request['description'];
        $task->status = $request['status'];
        $task->user_id = $request['user_id'];

        return $task;
    }
}
