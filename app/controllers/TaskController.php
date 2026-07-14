<?php

class TaskController extends ApplicationController
{
    private TaskService $taskService;
    //being able to inject a fake model for testing
    //but still following the framework way of constructing object
    public function __construct(?TaskService $taskService = null)
    {
        $this->taskService = $taskService ?? new TaskService(new TaskRepository());
    }

    public function newAction()
    {
        
    }

    public function createAction()
    {
        $taskData = $this->_getAllParams();

        $actionResult = $this->taskService->createTask($taskData);
 
        $this->view->actionResult = $actionResult;
        
    }
}