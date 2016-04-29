<?php

include_once ('./config.php');

session_start();

/**
 * 
 */
$info = explode('/', $_GET['q']);

$params = array();

foreach ($info as $v) {
    if ($v != '') {
        $params[] = $v;
    }
}

$action = "action";
$action .= (isset($params[1])) ? $params : 'Index';



