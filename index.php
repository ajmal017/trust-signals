<?php
    date_default_timezone_set('Europe/Moscow');
    mb_internal_encoding("UTF-8");
	define(ROOT, dirname(__FILE__));
	$file_name = $_SERVER['REQUEST_URI'];
	$list = parse_ini_file(ROOT."/additions/errors.ini");

	try {
        require_once ROOT.'/additions/config.php';
        require_once ROOT.'/additions/tabgeo.php';
        require_once ROOT.'/additions/mailer/PHPMailerAutoload.php';
        require_once ROOT.'/additions/functions.php';
		require_once ROOT.'/engine/classes/system/core.sys.php';
		require_once ROOT.'/engine/classes/system/db.sys.php';
		require_once ROOT.'/engine/classes/system/reader.sys.php';
		require_once ROOT.'/engine/classes/system/forms.sys.php';

		$page = "index";

		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		}

        if($page == "ajax" || $page == "admin") {
            if(isset($_GET['ajax-handle'])) {
                $page = $_GET['ajax-handle'];
                $path = ROOT."/engine/classes/ajax/".$page.".class.php";
            }
            elseif(isset($_GET['admin'])) {
                $page = $_GET['admin'];
                $path = ROOT."/engine/classes/admin/".$page.".class.php";
            }
        }
        else {
            $path = ROOT."/engine/classes/".$page.".class.php";
            if(!file_exists($path)){
                $page = "index";
                $path = ROOT."/engine/classes/".$page.".class.php";
            }
        }

		require_once $path;

		if(!class_exists($page))
			$obj = new Index();
		else
			$obj = new $page;
		if(method_exists($obj, "getBody")) {
			$mysqli = db::getObject();

            if(isset($_GET['aff'])) {
                $id = abs((int)$_GET['aff']);
                $user_aff = $mysqli->query("SELECT `id` FROM `user_aff` WHERE `id` = '{$id}'");
                if($user_aff->num_rows == 1) {
                    $date = date("Y-m-d");
                    $_SESSION['aff_id'] = $id;
                    $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND `user` = '{$id}'");
                    if($isset_day->num_rows == 1) {
                        $user_aff_f = $isset_day->fetch_assoc();
                        $mysqli->query("UPDATE `history` SET `unique` = `unique` + 1 WHERE `date` = '{$date}' AND `user` = '{$id}'");
                    }
                    else {
                        $mysqli->query("INSERT INTO `history` (`date`, `user`, `unique`) VALUES ('{$date}', '{$id}', '1')");
                    }
                }
            }

			$obj->getBody();
		}
		else {
			throw new Exception(2);
		}
	}
	catch(Exception $e) {
		$code = $e->getMessage();
		echo "<p>". $list[$code] ."</p>";
	}
?>