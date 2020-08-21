<?php


namespace application\controllers;

use application\core\Controller;
use application\core\View;

class MainController extends Controller
{
    public function indexAction()
    {
        (!empty($this->parameters['page']) && $this->parameters['page'] >= 1) ? $page = intval($this->parameters['page']) : $page = 1;
        (!empty($this->parameters['sortBy'])) ? $sortBy = $this->parameters['sortBy'] : $sortBy = 'user';
        (!empty($this->parameters['sortDirection'])) ? $sortDirection = $this->parameters['sortDirection'] : $sortDirection = 'ASC';
        $tasksStatus = null;
        if(array_key_exists('tasksStatus', $this->parameters)){
            if ($this->parameters['tasksStatus'] !== null) {
                $tasksStatus = $this->parameters['tasksStatus'];
            }
        }
        $result = $this->model->getTasks($page, $sortBy, $sortDirection, $tasksStatus);
        if($page > $result['totalPagesCount'] && $result['totalPagesCount'] > 0){
            $this->view->redirect($result['totalPagesCount']);
        }
        $this->view->renderView([
            'tasks' => $result['tasks'],
            'pagination' => $result['pagination'],
            'totalTasksCount' => $result['totalTasksCount'],
            'shownTasksCount' => $result['shownTasksCount'],
            'sortBy' => $sortBy,
            'sortDirection' => $sortDirection,
            'tasksStatus' => $tasksStatus,
        ]);
    }

    public function addtaskAction()
    {
        if (!empty($_POST)) {
            $validationResult = $this->model->getTaskValidationResult($_POST);
            if ($validationResult === true) {
                $this->model->addTask($_POST);
                $this->view->message('Успешно', 'Задача добавлена!');
            } else {
                $this->view->message('Ошибка', $validationResult);
            }
        }
        $this->view->renderView();
    }

    public function changeSortByAction()
    {
        $sortByFears = ['user', 'email'];
        foreach ($sortByFears as $fear) {
            if ($fear == $this->parameters['sortby']) {
                $_SESSION['sortBy'] = $fear;
            }
        }
        $this->view->redirectBack();
    }

    public function changeSortDirectionAction()
    {
        $sortDirectionFears = ['ASC', 'DESC'];
        foreach ($sortDirectionFears as $fear) {
            if ($fear == strtoupper($this->parameters['sortdirection'])) {
                $_SESSION['sortDirection'] = $fear;
            }
        }
        $this->view->redirectBack();
    }

    public function changeTaskStatusAction()
    {
        $taskStatus = $this->parameters['taskstatus'];
        switch ($taskStatus) {
            case 0:
                $_SESSION['tasksStatus'] = 0;
                break;
            case 1:
                $_SESSION['tasksStatus'] = 1;
                break;
            default:
                $_SESSION['tasksStatus'] = null;
        }
        $this->view->redirectBack();
    }

    public function deleteParamsAction()
    {
        unset($_SESSION['sortBy']);
        unset($_SESSION['sortDirection']);
        unset($_SESSION['tasksStatus']);
        $this->view->redirect('');
    }

    public function reloadPageAction()
    {
        $this->view->redirectBack();
    }

    public function switchTaskStatusAction()
    {
        if ($this->admin === true) {
            $taskId = $this->parameters['taskid'];
            $this->model->switchTaskStatus($taskId);
            $this->view->redirectBack();
        } else {
            View::errorCode(404);
        }
    }

    public function deleteTaskAction()
    {
        if ($this->admin === true) {
            $taskId = $this->parameters['taskid'];
            $this->model->deleteTask($taskId);
            $this->view->redirectBack();
        } else {
            View::errorCode(404);
        }
    }

    public function editTaskAction()
    {
        $taskId = $this->parameters['taskid'];
        $task = $this->model->getTaskById($taskId);
        if(!empty($_POST)){
            $validationResult = $this->model->getTaskValidationResult($_POST);
            if($validationResult == true){
                $taskEdited = $this->model->editTask($task, $_POST);
                if($taskEdited){
                    $this->view->message('Успешно', 'Задача отредактирована!');
                }else{
                    $this->view->message('Уведомление', 'Ничего не изменено');
                }
            }else{
                $this->view->message('Ошибка', $validationResult);
            }
        }
        $this->view->renderView([
            'task' => $task
        ]);
    }
}