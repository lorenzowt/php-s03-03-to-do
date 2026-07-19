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

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTaskState()
    {
        return $this->taskState;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function start()
    {
        $this->taskState = TaskState::STARTED;
        $this->startTime = date('Y-m-d H:i:s');
    }

    public function complete()
    {
        $this->taskState = TaskState::COMPLETED;
        $this->endTime = date('Y-m-d H:i:s');
    }

    public function reset()
    {
        $this->taskState = TaskState::PENDING;
        $this->startTime = null;
        $this->endTime = null;
    }

    public function restart()
    {
        $this->taskState = TaskState::STARTED;
        $this->startTime = date('Y-m-d H:i:s');
        $this->endTime = null;
    }
}