<?php
	define(ROOT, dirname(__FILE__));
	require_once ROOT.'/additions/config.php';
    require_once ROOT.'/additions/functions.php';
    require_once ROOT.'/engine/classes/system/db.sys.php';
    $mysqli = db::getObject();
    $time = time();
    $u = $mysqli->query("SELECT COUNT(*) FROM `users` WHERE {$time} - `lasttime` <= 3");
    print_r($u);
?>