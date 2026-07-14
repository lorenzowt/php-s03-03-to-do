<?php 

class TaskService
{
    public function __construct(
        private TaskRepository $taskReposit,
        private string $jsonPath = ROOT_PATH . '/data/tasks.json',
        ) {   
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

        if (!$this->taskRepository->createTask($task)){
            return TaskActionResult::failure(['Failed to save in database']);
        }
        
        return TaskActionResult::success($task);
   }

    private function normalizeData(array $taskData): array
    {
        if (!isset($taskData['title'])){
            $taskData['title'] = trim($taskData['title']);
        }

        return $taskData;
    }

    private function validateData(array $taskData): array
    {
        $errors = [];
        if (!isset($taskData['title'])) {

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