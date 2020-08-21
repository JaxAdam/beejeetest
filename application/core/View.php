<?php


namespace application\core;


class View
{

    public $parameters;
    public $layout = 'default';
    public $viewPath;

    public function __construct($parameters){
        $this->parameters = $parameters;
        $this->viewPath = $parameters['controller']. '/' . $parameters['action'];
    }

    public function renderView($vars = []){
        extract($vars);
        (empty($this->parameters['userEmail'])) ?: $userEmail = $this->parameters['userEmail'];
        (empty($this->parameters['userName'])) ?:  $userName = $this->parameters['userName'];
        (empty($this->parameters['status'])) ? $admin = false :  $admin = true;
        $viewPath = '../application/views/templates/' . $this->layout . '/' . $this->viewPath . '.php';
        if(file_exists($viewPath)){
            ob_start();
            require $viewPath;
            $content = ob_get_clean();
            require '../application/views/templates/'.$this->layout.'/layout.php';
        }
    }

    public function redirect($url) {
        header('location: /'.$url);
        exit;
    }

    public function redirectBack(){
        header('location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

    public static function errorCode($code) {
        http_response_code($code);
        $path = '../application/views/' . $code.'.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    public function message($status, $message){
        exit(json_encode(['status' => $status, 'message' => $message], JSON_UNESCAPED_UNICODE));
    }

    public function location($url) {
        exit(json_encode(['url' => $url], JSON_UNESCAPED_UNICODE));
    }

}