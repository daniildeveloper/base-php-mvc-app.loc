<?php

function __autoload($classname) {
    switch ($classname[0]) {
        case 'C':
            include_once "c/$classname.php";
            break;
        case 'M':
            include_once "m/$classname.php";
            break;
    }
}

define("BASE_URL", "/");
define("HOST", "localhost");
define("DBNAME", "cms");
define("USER", "root");
define("PASSWORD", "");

//media
define("JS_DIR", "media/js/");
define("CSS_DIR", "media/css");
