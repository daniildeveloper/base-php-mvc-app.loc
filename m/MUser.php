<?php

namespace app\m;

class MUser {

    private static $instance;
    private $msqli;
    private $sid;
    private $uid;
    private $onlineMap;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new MUser();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->msqli = MMSQL::instance();
        $this->sid = null;
        $this->uid = null;
        $this->onlineMap = null;
    }

    public function clearSessions() {
        $min = date("Y-m-d H:i:s", time() - 60 * 20);
        $t = "time_last < '%s'";
        $where = sprintf($t, $min);
        $this->msqli->delete('sessions', $where);
    }

    public function login($login, $password, $remember = true) {
        $user = $this->getByLogin($login);

        if ($user == null) {
            return false;
        }

        $idUser = $user['id_user'];

        if ($user['password'] != md5($password)) {
            return false;
        }

        if ($remember) {
            $expire = time() + 3600 * 24 * 100;
            setcookie('login', $login, $expire);
            setcookie('password', md5($password), $expire);
            $this->sid = $this->openSession($idUser);

            return true;
        }
    }

    public function logout() {
        setcookie('login', '', time() - 1);
        setcookie('password', '', time() - 1);
        unset($_COOKIE['login']);
        unset($_COOKIE['password']);
        unset($_SESSION['sid']);

        $this->sid = null;
        $this->uid = null;
    }

    public function getByLogin($login) {
        $t = "SELECT * FROM users WHERE login = '%s'";
        $query = sprintf($t, mysqli_real_escape_string($login));
        $result = $this->msqli->select($query);
        return $result[0];
    }

    private function openSession($idUser) {
        $sid = $this->generateStr(10);

        $now = date("y-m-d H:i:s");
        $session = array();
        $session['id_user'] = $idUser;
        $session['sid'] = $sid;
        $session['time_start'] = $now;
        $session['time_last'] = $now;

        $this->msqli->insert('session', $session);

        $_SESSION['sid'] = $sid;

        return $sid;
    }

    private function generateStr($length = 10) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;

        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }
        return $code;
    }

}
