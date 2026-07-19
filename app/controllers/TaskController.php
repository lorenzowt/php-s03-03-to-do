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

    public function updateAction()
    {
        $taskData = $this->_getAllParams();

        $taskData = $this->normalizeData($taskData);

        $errors = $this->validateData($taskData);

        if(!empty($errors)) {
            $this->view->actionResult = TaskActionResult::failure($errors);
            return;
        }
        $id = $taskData['id'];
        $action = $taskData['action'];

        $actionResult = match ($action) {
            'start' => $this->taskService->start($id),
            'complete' => $this->taskService->complete($id),
            'restart' => $this->taskService->restart($id),
            'reset' => $this->taskService->reset($id),
            default => TaskActionResult::failure(['Invalid action'])
        };

        $this->view->actionResult = $actionResult;

        $this->view->action = $action;
    }

    public function deleteAction()
    {
        $id = filter_var($this->_getParam('id'), FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $this->view->actionResult = TaskActionResult::failure(['Invalid task ID format']);
            return;
        }

        $actionResult = $this->taskService->delete($id);

        $this->view->actionResult = $actionResult;
    }

    public function saveAction()
    {
        $taskData = $this->_getAllParams();

        $taskData = $this->normalizeData($taskData);

        $errors = $this->validateData($taskData);

        if(!empty($errors)) {
            $this->view->actionResult = TaskActionResult::failure($errors);
            return;
        }

        $actionResult = $this->taskService->edit($taskData);
 
        $this->view->actionResult = $actionResult;
        
    }

    public function editAction()
    {
        $id = $this->_getParam('id');

        $errors = $this->validateData([$id]);

        if(!empty($errors)) {
            $this->view->actionResult = TaskActionResult::failure($errors);
            return;
        }

        $actionResult = $this->taskService->findById($id);

        $this->view->actionResult = $actionResult;

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

        if (isset($taskData['id'])) {
        
            $id = filter_var($taskData['id'], FILTER_VALIDATE_INT);

            if ($id === false || $id === null) {
                $error[] = 'Invalid ID format';
            }
        }
        return $errors;
    }

    private function normalizeData(array $taskData): array
    {
        if (isset($taskData['title'])){
            $taskData['title'] = trim($taskData['title']);
        }

        return $taskData;
    }
}