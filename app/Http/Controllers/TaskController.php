<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Services\TaskService;

class TaskController extends Controller
{
    private $taskService;

    function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        return $this->taskService->getAllTask();
    }

    public function store(TaskStoreRequest $request)
    {
        return $this->taskService->storeTask($request);
    }

    public function show($id)
    {
        return $this->taskService->getTask($id);
    }

    public function update(TaskStoreRequest $request, $id)
    {
        return $this->taskService->updateTask($request, $id);
    }

    public function destroy($id)
    {
        return $this->taskService->deleteTask($id);
    }
}
