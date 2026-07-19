<?php 

class TaskService
{
    public function __construct(
        private ?TaskRepository $taskRepository = null,
        ) {   
            $this->taskRepository = $taskRepository ?? new TaskRepository();
        }

   public function createTask(array $taskData): TaskActionResult
   {
        if (!isset($taskData['title'])){
            return TaskActionResult::failure(['Title is required']);
        }

        $taskData = $this->normalizeData($taskData);

        $errors = $this->validateData($taskData);

        if (!empty($errors)) {
            return TaskActionResult::failure($errors);
        }

        $task = new Task(
            $taskData['title']
        );

        $this->taskRepository->create($task);

        return TaskActionResult::success($task);
   }

    public function listTasks(): array
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

    private function normalizeData(array $taskData): array
    {
        if (isset($taskData['title'])){
            $taskData['title'] = trim($taskData['title']);
        }

        return $taskData;
    }

    private function validateData(array $taskData): array
    {
        $errors = [];
        if (isset($taskData['title'])) {

            $title = $taskData['title'];

            if ($title === '') {
                $errors[] = 'Title is required';
            }

            if (strlen($title) > 150) {
                $errors[] = 'Title cannot be longer than 150 characters';
            }
        }
        else {
            $error[] = 'Title was not received';
        }
        return $errors;
    }
}