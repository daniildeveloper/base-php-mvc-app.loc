<?php

namespace app\c;

/**
 * Class CBase
 */
abstract class CBase extends CController {

    /**
     * page title. SEO: h1
     * @var type String
     */
    protected $title;

    /**
     * content 
     * @var type String
     */
    protected $content;

    /**
     * needed login
     * @var type boolean
     */
    protected $needLogin;

    /**
     * if user is authorized : true, else false. default null.
     * @var type username
     */
    protected $user;

    /**
     * Keywords. Will be displayed in head in meta-tag.
     * @var type keywords of website.
     */
    protected $keywords;

    /**
     * description
     * @var type String
     */
    protected $description;

    /**
     *
     * @var type top, main menu
     */
    protected $topMenu;

    /**
     *
     * @var type left sidebar menu
     */
    protected $leftMenu;

    /**
     * class construct function
     */
    function __construct() {
        $this->needLogin = FALSE;
        $this->keywords = '';
        $this->description = '';
        //todo: topMenu, leftMenu, user
    }

    protected function before() {
        if ($this->needLogin && $this->user === null) {
            $this->redirect('/auth/login');
        }
        $this->title = 'Site title';
        $this->content = '';
    }

    public function render() {
        $vars = array('title' => $this->title,
            'content' => $this->content,
            "keywords" => $this->keywords,
            'description' => $this->description,
            'topMenu' => $this->topMenu,
            'leftMenu' => $this->leftMenu);

        $page = $this->template('v/vMain.php', $vars);
    }

}
