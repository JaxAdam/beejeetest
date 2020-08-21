<?php


namespace application\core;

use application\core\View;


abstract class Controller
{
    public $parameters;
    public $view;
    public $model;
    public $admin = false;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
        $this->view = new View($parameters);
        $this->model = $this->loadModel($parameters['controller']);
        if(array_key_exists('status',$this->parameters)){
            if($this->parameters['status'] === 1){
                $this->admin = true;
            }
        }
    }

    public function loadModel($modelName) {
        $modelPath = 'application\models\\'.ucfirst($modelName);
        if (class_exists($modelPath)) {
            return new $modelPath;
        }
    }
}