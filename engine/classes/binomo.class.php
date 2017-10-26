<?php
class Binomo extends Core {
	public function getTitle() {
		echo "Web Elly BooT Binomo";
	}
	public function getContent() {
		$adds = new Additions();
		if($adds->isAuth()) {
			global $mysqli;
			$date = date("Y-m-d");
			$this->initBasicData();
			$this->templateEdit("title_content", "Web Elly BooT Binomo");
			$user = $adds->getUserData();
			$data = new Reader("default");
			$data->view("elly/wrap");
			$elly_val = 0;
			$elly = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'elly' LIMIT 1");
			if($elly->num_rows == 1) {
				$elly = $mysqli->assoc($elly);
				$elly_val = $elly['value'];
			}
			$web_demo = 0;
			$web = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo' LIMIT 1");
			if($web->num_rows == 1) {
				$web = $mysqli->assoc($web);
				$web_demo = $web['value'];
			}
			if(
				(
					((
						($elly_val == 0 && $user['time_vip'] > 0) ||
						($elly_val == 1 && $user['time_vip'] > 33120)
					) || ($web_demo == "1" && $user['web_lasttime'] > 0 && $user['time_vip'] == 0)) && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") || $user['group'] == "admin") {
				$qs = $mysqli->query("SELECT `name`, `translate`, `id`, `binomo`, `binomo_code` FROM `quotes_list`");
				if($qs->num_rows > 0) {
					$quotes_boxes = "";
					$row = $mysqli->assoc($qs);
					do {
						$quotes_boxes .= R::read("default", "binomo/pair", array(
							"code" => strtoupper($row['translate']),
							"binomo" => strtoupper($row['binomo_code']),
							"win" => $row['binomo']
						));
					}
					while($row = $mysqli->assoc($qs));
				}
				$history_box = "";
				$history = $mysqli->query("SELECT * FROM `binomo_history` WHERE `user_id` = '{$user['id']}' ORDER BY `date` DESC, `id` DESC LIMIT 15");
				if($history->num_rows) {
					$item = $mysqli->assoc($history);
					do {
						$history_box .= R::read("default", "web/item", array(
							"date" => $item['date'],
							"code" => strtoupper($item['symbol']),
							"position" => $item['position'],
							"position_name" => $item['position'] == "up" ? "Вверх" : "Вниз",
							"rate" => $item['rate'].$item['currency'],
							"profit" => $item['profit'],
							"status" => $item['status'],
							"percent" => $item['percent'] . "%",
							"power" => $item['percent'] > 79 ? "power" : ""
						));
					}
					while($item = $mysqli->assoc($history));
				}
				else {
					$history_box = R::read("default", "web/empty", array());
				}
				$is_auth = "false";
				if(isset($_SESSION['binomo']))
					$is_auth = "true";
				echo R::read("default", "binomo/page", array(
					"pairs_list" => $quotes_boxes,
					"history" => $history_box,
					"item" => R::read("default", "web/item", array(
						"date" => "",
						"code" => "{symbol}",
						"position" => "",
						"position_name" => "",
						"rate" => "",
						"status" => "",
						"profit" => "",
					)),
					"item_with_process" => R::read("default", "web/with", array(
						"date" => "",
						"code" => "{symbol}",
						"position" => "",
						"position_name" => "",
						"rate" => "",
						"status" => "",
						"profit" => "",
					)),
					"URI" => URI,
					"auth" => $is_auth
				));
			}
			else {
				if($user['confirm'] != "1") {
					$confirm = new Reader("default");
					$confirm->view("cabinet/confirm");
					$confirm->change("uri", URI);
					echo $confirm->show();
				}
				elseif($user['time_vip'] < 33120 && $elly_val == 1) {
					if($web_demo == "1" && $user['web_is'] == 1) {
						$lock = new Reader("default");
						$lock->view("web/lock");
						$lock->change("uri", URI);
						echo $lock->show();
					}
					else {
						$lock = new Reader("default");
						$lock->view("cabinet/lock2");
						$lock->change("uri", URI);
						echo $lock->show();
					}
				}
				elseif($user['time_vip'] <= 0) {
					$lock = new Reader("default");
					$lock->view("cabinet/lock");
					$lock->change("uri", URI);
					echo $lock->show();
				}
				elseif(date("l") == "Saturday" ||  date("l") == "Sunday") {
					$output = new Reader("default");
					$output->view("cabinet/output");
					echo $output->show();
				}
			}
		}
		else {
			$adds->redirect(URI."/home/");
		}
	}
}
            

?>