<?php
namespace app\m;

class MPages {

    private static $instance;
    private $db;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new MPages();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->db = MMSQL::instance();
    }

}
