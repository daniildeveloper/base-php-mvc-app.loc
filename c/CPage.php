<?php

namespace app\c;

class CPage extends CBase {
    public function __construct() {
        parent::__construct();
    }

    public function before() {
        parent::before();
    }

    public function actionIndex() {
        $url = implode('/', $this->params);
        if ($url == '') {
            $url = 'home';
        }
    }

}
