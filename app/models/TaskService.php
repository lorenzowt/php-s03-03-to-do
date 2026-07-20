<?php 

class TaskService
{
    public function __construct(
        private ?TaskRepository $taskRepository = null,
        ) {   
            $this->taskRepository = $taskRepository ?? new TaskRepository();
        }

   public function create(string $title): TaskActionResult
   {
        $task = new Task($title);

        $this->taskRepository->create($task);

        return TaskActionResult::success($task);
   }

    public function list(): array
    {
        return $this->taskRepository->list();
    }

    public function findById(int $id): TaskActionResult
    {
        $task = $this->taskRepository->findById($id);
        
        if ($task === null) {
            return TaskActionResult::failure(["task with ID: $id does not exist"]);
        }

        return TaskActionResult::success($task);
    }

    public function start(int $id): TaskActionResult
    {
        $task = $this->taskRepository->findById($id);
        
        if ($task === null) {
            return TaskActionResult::failure(["task with ID: $id does not exist"]);
        }

        $taskState = $task->getTaskState();

        if ($taskState === TaskState::COMPLETED || $taskState === TaskState::STARTED) {
            return TaskActionResult::failure(["Cannot start a $taskState->value task"]);
        }

        $task->start();
        
        $this->taskRepository->update($task);

        return TaskActionResult::success($task);
    }

    public function complete(int $id): TaskActionResult
    {
        $task = $this->taskRepository->findById($id);
        
        if ($task === null) {
            return TaskActionResult::failure(["task with ID: $id does not exist"]);
        }

        $taskState = $task->getTaskState();

        if ($taskState === TaskState::COMPLETED || $taskState === TaskState::PENDING) {
            return TaskActionResult::failure(["Cannot complete a $taskState->value task"]);
        }

        $task->complete();
        
        $this->taskRepository->update($task);

        return TaskActionResult::success($task);
    }

    public function reset(int $id):TaskActionResult
    {
        $task = $this->taskRepository->findById($id);
        
        if ($task === null) {
            return TaskActionResult::failure(["task with ID: $id does not exist"]);
        }

        $taskState = $task->getTaskState();

        if ($taskState === TaskState::PENDING) {
            return TaskActionResult::failure(["Cannot reset a $taskState->value task"]);
        }

        $task->reset();
        
        $this->taskRepository->update($task);

        return TaskActionResult::success($task);
    }

    public function restart(int $id):TaskActionResult
    {
        $task = $this->taskRepository->findById($id);
        
        if ($task === null) {
            return TaskActionResult::failure(["task with ID: $id does not exist"]);
        }

        $taskState = $task->getTaskState();

        if ($taskState === TaskState::PENDING )  {
            return TaskActionResult::failure(["Cannot restart a $taskState->value task"]);
        }

        $task->restart();
        
        $this->taskRepository->update($task);

        return TaskActionResult::success($task);
    }

    public function delete(int $id): TaskActionResult
    {
        $task = $this->taskRepository->findById($id);

        if (!$this->taskRepository->delete($id)) {
            return TaskActionResult::failure(["Task with ID: $id does not exist"]);
        }

        return TaskActionResult::success($task);
    }

    public function edit(array $taskData): TaskActionResult
    {
        $id = $taskData['id'];

        $task = $this->taskRepository->findById($id); 

        if ($task === null){
            return TaskActionResult::failure(["Task with ID: $id does not exist"]);
        }
        
        $task->setTitle($taskData['title']);

        $this->taskRepository->update($task);

        return TaskActionResult::success($task);
    }
}