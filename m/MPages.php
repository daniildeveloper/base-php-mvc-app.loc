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

    public function makeTree($startLevel = 0) {
        $map = array();
        $pages = "SELECT * FROM pages WHERE id_parent = '$startLevel'";

        if (!empty($pages)) {
            foreach ($pages as $page) {
                $page['children'] = $this->makeTree($page['id_page']);
                $map[] = $page;
            }
            return $map;
        }
    }

    private function makeFullUrl($idParent, $url) {
        if ($idParent == 0) {
            return $url;
        }

//        $page = $this->
    }

    /**
     *
     * @param type $id
     * @return type return page 
     */
    public function get($id) {
        $idUse = (int) $id;
        $res = $this->db->select("SELECT * FROM pages WHERE id_page = '$idUse'");
        return $res;
    }

    public function getByUrl($url) {
        $urlUse = mysqli_escape_string($this->db, $url);
        $res = $this->db->select("SELECT * FROM pages WHERE full_cashe_url = '$urlUse'");
        return $res[0];
    }

}
