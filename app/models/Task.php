<?php

class Task
{
    public function __construct(
        private string $title,
        private TaskState $taskState = TaskState::PENDING,
        private ?string $startTime = null,
        private ?string $endTime = null,
        private ?int $id = null,
        private int $userId = 1,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'taskState' => $this->taskState->value,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'userId' => $this->userId,
        ];
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}