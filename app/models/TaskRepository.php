<?php

class TaskRepository
{
    public function __construct(
        private string $jsonPath = ROOT_PATH . '/data/tasks.json'
    ){
    }

    public function create(Task $task)
    {
        $jsonData = $this->loadData();
        $nextId = $jsonData['nextId'];

        $task->setId($nextId);

        $jsonData['tasks'][$nextId] = $task->toArray();
        $jsonData['nextId']++;

        $this->saveData($jsonData);      
    }

    private function loadData(): array 
    {
        $jsonString = file_get_contents($this->jsonPath);
        // true so it returns an array and not an StdObject
        return json_decode($jsonString, true);
    }

    private function saveData(array $jsonData): void
    {
        $jsonString = json_encode($jsonData, JSON_PRETTY_PRINT);

        file_put_contents($this->jsonPath, $jsonString);
    }

}