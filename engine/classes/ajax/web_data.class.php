<?php
class Web_Data extends Core {
	public function getTitle() {}
	public function getContent() {
		$this->changeLauncher("clean");
		$adds = new Additions();
		$action = '';
		if(isset($_POST['action'])) {
			$action = $_POST['action'];
		}
		global $mysqli;
		if($adds->isAuth()) {
			$user = $adds->getUserData();
			$date = date("Y-m-d");
			if($action == 'change-time' && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
        $res = array("answer" => "", "text" => "");
        $time = $adds->toInteger($user['time_vip']);
        $web_demo = 0;
				$web = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo' LIMIT 1");
				if($web->num_rows == 1) {
					$web = $mysqli->assoc($web);
					$web_demo = $web['value'];
				}
        if($time - 1 > 0) {
          $res['answer'] = 'normal';
          $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` - 1 WHERE `id` = '{$user['id']}'");
          $res['text'] = $adds->timeleft($time - 1);
        }
        elseif($web_demo == "1" && $user['web_lasttime'] - 1 >= 0) {
        	$res['answer'] = 'demo';
        	$mysqli->query("UPDATE `users` SET `web_lasttime` = `web_lasttime` - 1 WHERE `id` = '{$user['id']}'");
        	$res['text'] = $user['web_lasttime'] - 1;
        }
        else {
          $res['answer'] = 'over';
          $mysqli->query("UPDATE `users` SET `time_vip` = '0' WHERE `id` = '{$user['id']}'");
          $lock = new Reader("default");
          $lock->view("cabinet/lock");
          $lock->change("uri", URI);
          $res['text'] = $lock->show();
        }
        echo json_encode($res);
	    }
			elseif($action == "saved" && isset($_POST['symbol']) && isset($_POST['percent'])) {
				$percent = $adds->toInteger($_POST['percent']);
				if($percent) {
					$symbol = $adds->siftText($_POST['symbol']);
					$mysqli->query("UPDATE `quotes_list` SET `win` = '{$percent}' WHERE `translate` = '{$symbol}'");
				}
			}
			elseif($action == "clear") {
				$mysqli->query("DELETE FROM `web_history` WHERE `user_id` = '{$user['id']}'");
				echo R::read("default", "web/empty", array());
			}
			elseif($action == "upload" && isset($_POST['num'])) {
				$num = $adds->toInteger($_POST['num']);
				$history_box = "";
				$history = $mysqli->query("SELECT * FROM `web_history` WHERE `user_id` = '{$user['id']}' ORDER BY `date` DESC, `id` DESC LIMIT {$num}, 10");
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
							"percent" => $item['percent'] . "%"
						));
					}
					while($item = $mysqli->assoc($history));
				}
				echo $history_box;
			}
			elseif($action == "create" && isset($_POST['percent']) && isset($_POST['profit']) && isset($_POST['status']) && isset($_POST['rate']) && isset($_POST['date']) && isset($_POST['index']) && isset($_POST['position']) && isset($_POST['currency']) && isset($_POST['symbol'])) {
				$position = $_POST['position'] == "up" ? "up" : "down";
				$percent = $adds->toInteger($_POST['percent']);
				$currency = $adds->siftText($_POST['currency']);
				$symbol = $adds->siftText($_POST['symbol']);
				$status = $adds->siftText($_POST['status']);
				$index = $adds->siftText($_POST['index']);
				$date = $adds->siftText($_POST['date']);
				$profit = round(abs((float)$_POST['profit']), 1);
				$rate = $adds->toInteger($_POST['rate']);
				$currency = strtoupper($currency);
				if(empty($index) || !$mysqli->query("SELECT `index`, `user_id` FROM `web_history` WHERE `user_id` = '{$user['id']}' AND `index` = '{$index}'")->num_rows) {
					if($mysqli->query("SELECT `name`, `translate` FROM `quotes_list` WHERE `name` = '{$symbol}' OR `translate` = '{$symbol}' LIMIT 1")->num_rows) {
						if($status == "win" || $status == "lose" || $status == "zero" || $status == "signal") {
							if(preg_match("/^\d{4}\-\d{2}\-\d{2}\s{1}\d{2}\:\d{2}\:\d{2}$/", $date)) {
								if($status == "win")
									$profit = "+{$profit}{$currency}";
								elseif($status == "lose")
									$profit = "-{$profit}{$currency}";
								elseif($status == "zero")
									$profit = "Возврат";
								else 
									$profit = "Инвестиция";
								$symbol = $symbol == "XAUUSD" ? "GOLD" : $symbol;
								$mysqli->query("INSERT INTO `web_history` SET `percent` = '{$percent}', `symbol` = '{$symbol}', `position` = '{$position}', `profit` = '{$profit}', `status` = '{$status}', `rate` = '{$rate}', `date` = '{$date}', `user_id` = '{$user['id']}', `currency` = '{$currency}', `index` = '{$index}'");
								if($mysqli->query("SELECT `user_id` FROM `web_history` WHERE `user_id` = '{$user['id']}' LIMIT 71")->num_rows > 70) {
									$mysqli->query("DELETE FROM `web_history` WHERE `user_id` = '{$user['id']}' ORDER BY `id` ASC LIMIT 1");
								}
								$process = "";
								if($status == "signal") {
									$process = R::read("default", "web/process", array());
								}
								echo "create";
							}
							else {
								echo "error";
							}
						}
						else {
							echo "error";
						}
					}
					else {
						echo "error";
					}
				}
				else {
					echo "error";
				}
			}
			elseif($action == "update" && isset($_POST['percent']) && isset($_POST['profit']) && isset($_POST['status']) && isset($_POST['rate']) && isset($_POST['date']) && isset($_POST['index']) && isset($_POST['position']) && isset($_POST['currency']) && isset($_POST['symbol'])) {
				$position = $_POST['position'] == "up" ? "up" : "down";
				$percent = $adds->toInteger($_POST['percent']);
				$currency = $adds->siftText($_POST['currency']);
				$symbol = $adds->siftText($_POST['symbol']);
				$status = $adds->siftText($_POST['status']);
				$index = $adds->siftText($_POST['index']);
				$date = $adds->siftText($_POST['date']);
				$profit = round(abs((float)$_POST['profit']), 1);
				$rate = $adds->toInteger($_POST['rate']);
				$currency = strtoupper($currency);
				if(1) {
					if($mysqli->query("SELECT `name`, `translate` FROM `quotes_list` WHERE `name` = '{$symbol}' OR `translate` = '{$symbol}' LIMIT 1")->num_rows) {
						if($status == "win" || $status == "lose" || $status == "zero" || $status == "signal") {
							if(preg_match("/^\d{4}\-\d{2}\-\d{2}\s{1}\d{2}\:\d{2}\:\d{2}$/", $date)) {
								if($status == "win")
									$profit = "+{$profit}{$currency}";
								elseif($status == "lose")
									$profit = "-{$profit}{$currency}";
								elseif($status == "zero")
									$profit = "Возврат";
								$symbol = $symbol == "XAUUSD" ? "GOLD" : $symbol;
								$get_id = -1;
								$g = $mysqli->query("SELECT `user_id`, `id`, `symbol`, `status` FROM `web_history` WHERE `status` = 'signal' AND `user_id` = '{$user['id']}' AND `symbol` = '{$symbol}' AND `date` < '{$date}'  ORDER BY `id` ASC LIMIT 1");
								if($g->num_rows == 1) {
									$g = $mysqli->assoc($g);
									$get_id = $g['id'];
									$mysqli->query("UPDATE `web_history` SET `profit` = '{$profit}', `status` = '{$status}', `rate` = '{$rate}', `date` = CONCAT(`date`, '<br/>', '{$date}') WHERE `id` = '{$get_id}' AND `user_id` = '{$user['id']}'");
									echo "updated";
								}
								else {
									echo "error";
								}
							}
							else {
								echo "error";
							}
						}
						else {
							echo "error";
						}
					}
					else {
						echo "error";
					}
				}
				else {
					echo "error";
				}
			}
			else {
				echo "error";
			}
		}
		else {
			echo "auth";
		}
	}
}
?>