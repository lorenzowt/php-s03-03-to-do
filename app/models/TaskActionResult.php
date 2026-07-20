<?php

class TaskActionResult
{
    private function __construct(
        private bool $isSuccessful,
        private array $errors,
        private ?Task $task,
    ){
    }

    public static function success(Task $task): self
    {
        return new TaskActionResult(true, [], $task);
    }

    public static function failure(array $errors): self
    {
        return new TaskActionResult(false, $errors, null);
    }


    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }
}