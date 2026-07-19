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

    public function listAction()
    {
        $taskList = $this->taskService->listTasks();

        $this->view->taskList = $taskList;
    }

    public function showAction()
    {
        $id = filter_var($this->_getParam('id'), FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            return $this->view->actionResult = TaskActionResult::failure(['Invalid task ID format']);
        }

        $actionResult = $this->taskService->findById($id);

        $this->view->actionResult = $actionResult;   
    }
}