<?php

namespace app\c;

abstract class CController {
    /**
     *
     * @var type array with params. $_GET
     */
    protected $params;

    /**
     * template generation
     */
    protected abstract function render();

    /**
     * any do before main action
     */
    protected abstract function before();

    /**
     *
     * @param type $action is any controller method that must work at $this;)) time
     * @param type $params - array with any params from $_GET request
     */
    public function request($action, $params) {
        $this->params = $params;
        $this->before();
        $this->$action();
        $this->render();
    }

    /**
     *  check if is get
     * @return type
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * check if is POST
     * @return type
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] == "POST";
    }

    /**
     * html to string
     *
     * @param type $filename - name of template
     * @param type $vars for html template
     */
    protected function template($filename, $vars = array()) {
        //vars for template
        foreach ($vars as $k => $v) {
            $$k = $v;
        }
        ob_start();
        include $filename;
        return ob_get_clean();
    }

    /**
     * if method doesnt exist return 404 ERROR
     */
    public function __call() {
        $this->p404();
    }

    public function p404() {
        //todo: make this method after controller Page
    }

    /**
     * function, that redirect to given url
     *
     * @param string $url - redirect to this url
     */
    public function redirect($url) {
        if ($url[0] == '/') {
            $url = BASE_URL . substr($url, 1);
        }
        header("location: $url");
        exit();
    }

}
