<?php


namespace application\controllers;


use application\core\Controller;

class AccountController extends Controller
{
    public function loginAction()
    {
        if (!empty($_POST)) {
            $validationResult = $this->model->getLoginValidationResult($_POST);
            if($validationResult === true){
                $this->model->login($_POST['taskerMail']);
                $this->view->location('/');
            }else{
                $this->view->message('Ошибка входа', $validationResult);
            }
        }
        $this->view->renderView();
    }

    public function signupAction()
    {
        if (!empty($_POST)) {
            $validationResult = $this->model->getRegistrationValidationResult($_POST);
            if($validationResult === true){
                $this->model->addNewUser($_POST);
                $this->model->login($_POST['taskerMail']);
                $this->view->location('/');
            }else{
                $this->view->message('Ошибка', $validationResult);
            }
        }
        $this->view->renderView();
    }

    public function logoutAction(){
        unset($_SESSION['userName']);
        unset($_SESSION['userToken']);
        unset($_SESSION['userId']);
        unset($_SESSION['userEmail']);
        unset($_SESSION['status']);
        $this->view->redirect('login');
    }
}