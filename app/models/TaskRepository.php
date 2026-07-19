<?php

class TaskRepository
{
    public function __construct(
        private string $jsonPath = ROOT_PATH . '/data/tasks.json'
    ){
    }

    public function create(Task $task)
    {
        $storageData = $this->loadData();
        $nextId = $storageData['nextId'];

        $task->setId($nextId);

        $storageData['tasks'][$nextId] = $task->toArray();
        $storageData['nextId']++;

        $this->saveData($storageData);      
    }

    public function list(): array
    {
        $tasksData = $this->loadData()['tasks'];

        if (empty($tasksData)){
            return $tasksData;
        }
        
        $taskList = [];

        foreach($tasksData as $taskData){
            $taskList[] = $this->hydrate($taskData);
        }

        return $taskList;
    }

    public function findById(int $id): ?Task
    {
        $tasksData = $this->loadData()['tasks'];

        if (!isset($tasksData[$id])) {
            return null;
        }

        return $this->hydrate($tasksData[$id]);
    }

    public function start(Task $task)
    {
        $tasksData = $this->loadData();

        $tasksData['tasks'][$task->getId()] = $task->toArray();

        $this->saveData($tasksData);
    }

    private function loadData(): array 
    {
        $jsonString = file_get_contents($this->jsonPath);
        // true so it returns an array and not an StdObject
        return json_decode($jsonString, true);
    }

    private function saveData(array $storageData): void
    {
        $jsonString = json_encode($storageData, JSON_PRETTY_PRINT);

        file_put_contents($this->jsonPath, $jsonString);
    }

    private function hydrate(array $taskData): Task
    {
        return new Task(
            $taskData['title'],
            TaskState::from($taskData['taskState']),
            $taskData['startTime'],
            $taskData['endTime'],
            $taskData['id'],
            $taskData['userId'],
        );
    }

}