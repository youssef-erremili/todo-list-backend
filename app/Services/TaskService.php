<?php

namespace App\Services;

use App\Events\TaskCreated;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getUserTasks($userId)
    {
        return $this->taskRepository->getAllTasks($userId);
    }

    public function getUserTaskById($userId, $taskId)
    {
        $task = $this->taskRepository->findById($taskId);

        // Optional: authorization check
        if ($task->user_id !== $userId) {
            abort(403, 'Unauthorized');
        }

        return $task;
    }

    public function createTask(array $data)
    {
        $task = $this->taskRepository->create($data);
        event(new TaskCreated($task));
        return $task;
    }

    public function updateTask($userId, $taskId, array $data)
    {
        $task = $this->getUserTaskById($userId, $taskId);
        return $this->taskRepository->update($task->id, $data);
    }

    public function deleteTask($userId, $taskId)
    {
        $task = $this->getUserTaskById($userId, $taskId);
        return $this->taskRepository->delete($task->id);
    }
}
