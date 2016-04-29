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

        $page = \app\m\MPages::instance()->getByUrl($url);

        if (empty($page)) {

        }
    }


    public function action404() {
        $this->title .= "->404";
        $this->content = $this->template('v/v_404.php');
    }

}
