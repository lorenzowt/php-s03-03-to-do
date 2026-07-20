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

        $titleData = $this->validateTitle($taskData);

        if ($titleData['error'] !== null) {
            return TaskActionResult::failure($titleData['error']);
        }

        $actionResult = $this->taskService->create($titleData['title']);
 
        $this->view->actionResult = $actionResult;
        
    }

    public function listAction()
    {
        $taskList = $this->taskService->list();

        $this->view->taskList = $taskList;
    }

    public function showAction()
    {
        $taskData = $this->_getAllParams();

        $idData = $this->validateId($taskData);

        if ($idData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        $actionResult = $this->taskService->findById($idData['id']);

        $this->view->actionResult = $actionResult;   
    }

    public function updateAction()
    {
        $taskData = $this->_getAllParams();

        $idData = $this->validateId($taskData);

        $actionData = $this->validateAction($taskData);

        if ($idData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        if ($actionData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        $id = $idData['id'];
        $action = $actionData['action'];

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
        $taskData = $this->_getAllParams();

        $idData = $this->validateId($taskData);

        if ($idData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        $actionResult = $this->taskService->delete($idData['id']);

        $this->view->actionResult = $actionResult;
    }

    public function saveAction()
    {
        $taskData = $this->_getAllParams();

        $idData = $this->validateId($taskData);

        $titleData = $this->validateTitle($taskData);

        if ($idData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        if ($titleData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        $taskData = [
            'id' => $idData['id'],
            'title' => $titleData['title']
        ];

        $actionResult = $this->taskService->edit($taskData);
 
        $this->view->actionResult = $actionResult;
        
    }

    public function editAction()
    {
        $taskData = $this->_getAllParams();

        $idData = $this->validateId($taskData);

        if ($idData['error'] !== null) {
            return TaskActionResult::failure($idData['error']);
        }

        $actionResult = $this->taskService->findById($idData['id']);

        $this->view->actionResult = $actionResult;

    }
    private function validateTitle(array $taskData): array
    {
        if (!isset($taskData['title'])) {
            return [
                'title' => null,
                'error' => 'Title is required',
            ];
        }

        $title = trim($taskData['title']);

        if ($title === '') {
            return [
                'title' => null,
                'error' => 'Title is required',
            ];
        }

        if (strlen($title) > 150) {
            return [
                'title' => null,
                'error' => 'Title cannot be longer than 150 characters',
            ];
        }

        return [
            'title' => $title,
            'error' => null,
        ];
    }

    private function validateId(array $taskData): array
    {
        if (!isset($taskData['id'])) {
            return [
                'id' => null,
                'error' => 'ID is required',
            ];
        }

        $id = filter_var($taskData['id'], FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            return [
                'id' => null,
                'error' => 'Invalid ID format',
            ];
        }

        return [
            'id' => $id,
            'error' => null,
        ];

    }

    private function validateAction(array $taskData): array 
    {
        if (!isset($taskData['action'])) {
            return [
                'action' => null,
                'error' => 'action is required',
            ];
        }

        $action = strtolower(trim($taskData['action']));

        return [
            'action' => $action,
            'error' => null,
        ];
    }
}