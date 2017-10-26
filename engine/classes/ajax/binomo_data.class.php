<?php
class Binomo_Data extends Core {
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
			if($action == "auth" && isset($_POST['email']) && isset($_POST['password'])) {
				$answer = array(
					"code" => "error"
				);
				$path = md5($_POST['email'].";".$_POST['password']);
	      $auth = curl_init();
	      curl_setopt($auth, CURLOPT_URL, "https://binomo.com/api/sign_in?device=web&locale=ru");
	      curl_setopt($auth, CURLOPT_HEADER, 0);
	      curl_setopt($auth, CURLOPT_RETURNTRANSFER, 1);
	      curl_setopt($auth, CURLOPT_FOLLOWLOCATION, 1);
	      curl_setopt($auth, CURLOPT_CONNECTTIMEOUT, 30);
	      curl_setopt($auth, CURLOPT_SSL_VERIFYPEER, false);
	      curl_setopt($auth, CURLOPT_COOKIEJAR, dirname(__FILE__)."/binomo/{$path}.txt");
	      curl_setopt($auth, CURLOPT_COOKIEFILE,  dirname(__FILE__)."/binomo/{$path}.txt");
	      curl_setopt($auth, CURLOPT_POST, true );
	      curl_setopt($auth, CURLOPT_POSTFIELDS, array(
	        "email" => $_POST['email'],
	        "g-recaptcha-response" => null,
	        "password" => $_POST['password'],
	        "remember_me" => false
	      ));

	      $data = curl_exec($auth);
	      $auth_answer = json_decode($data);

	      if(!$auth_answer->success) {
	        $answer['code'] = "auth_error";
	        exit(json_encode($answer));
	      }

	      $keys = curl_init();
	      curl_setopt($keys, CURLOPT_URL, "https://binomo.com/ru/trading" );
	      curl_setopt($keys, CURLOPT_HEADER, 0);
	      curl_setopt($keys, CURLOPT_RETURNTRANSFER, 1);
	      curl_setopt($keys, CURLOPT_FOLLOWLOCATION, 0);
	      curl_setopt($keys, CURLOPT_CONNECTTIMEOUT, 30);
	      curl_setopt($keys, CURLOPT_SSL_VERIFYPEER, false);
	      curl_setopt($keys, CURLOPT_COOKIEFILE, dirname(__FILE__)."/binomo/{$path}.txt");
	      $keys = curl_exec($keys); 
	      preg_match_all("#<body class=\".*\" data-config=\"(.*)\">#Usi", $keys, $keys_list);
      	preg_match_all("#deviceId&quot;:&quot;(.*)&quot;#Usi", $keys_list[1][0], $device_id);
	      if(!isset($device_id[1][0])) {
	        $answer['code'] = "auth_error";
	        exit(json_encode($answer));
	      }
	      $device_id = $device_id[1][0];
	      $authtoken = $auth_answer->data->authtoken;
	      $answer['code'] = "success";
	      $answer['authtoken'] = $authtoken;
	      $answer['device_id'] = $device_id;
	      $_SESSION['binomo'] = $path;
	      exit(json_encode($answer));
			}
			elseif($action == 'change-time' && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
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
					$mysqli->query("UPDATE `quotes_list` SET `win` = '{$percent}' WHERE `translate` = '{$symbol}' OR `binomo_code` = '{$symbol}'");
				}
			}
			elseif($action == "clear") {
				$mysqli->query("DELETE FROM `binomo_history` WHERE `user_id` = '{$user['id']}'");
				echo R::read("default", "web/empty", array());
			}
			elseif($action == "upload" && isset($_POST['num'])) {
				$num = $adds->toInteger($_POST['num']);
				$history_box = "";
				$history = $mysqli->query("SELECT * FROM `binomo_history` WHERE `user_id` = '{$user['id']}' ORDER BY `date` DESC, `id` DESC LIMIT {$num}, 10");
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
				if(empty($index) || !$mysqli->query("SELECT `index`, `user_id` FROM `binomo_history` WHERE `user_id` = '{$user['id']}' AND `index` = '{$index}'")->num_rows) {
					if($mysqli->query("SELECT `name`, `translate`, `binomo_code` FROM `quotes_list` WHERE `name` = '{$symbol}' OR `binomo_code` = '{$symbol}' OR `translate` = '{$symbol}' LIMIT 1")->num_rows) {
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
								$symbol = str_replace("/", "", $symbol);
								$mysqli->query("INSERT INTO `binomo_history` SET `percent` = '{$percent}', `symbol` = '{$symbol}', `position` = '{$position}', `profit` = '{$profit}', `status` = '{$status}', `rate` = '{$rate}', `date` = '{$date}', `user_id` = '{$user['id']}', `currency` = '{$currency}', `index` = '{$index}'");
								if($mysqli->query("SELECT `user_id` FROM `binomo_history` WHERE `user_id` = '{$user['id']}' LIMIT 71")->num_rows > 70) {
									$mysqli->query("DELETE FROM `binomo_history` WHERE `user_id` = '{$user['id']}' ORDER BY `id` ASC LIMIT 1");
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
				$symbol = str_replace("\/", "/", $symbol);
				if(1) {
					if($mysqli->query("SELECT `name`, `translate`, `binomo_code` FROM `quotes_list` WHERE `name` = '{$symbol}' OR `translate` = '{$symbol}' OR `binomo_code` = '{$symbol}' LIMIT 1")->num_rows) {
						if($status == "win" || $status == "lose" || $status == "zero" || $status == "signal") {
							if(preg_match("/^\d{4}\-\d{2}\-\d{2}\s{1}\d{2}\:\d{2}\:\d{2}$/", $date)) {
								if($status == "win")
									$profit = "+{$profit}{$currency}";
								elseif($status == "lose")
									$profit = "-{$profit}{$currency}";
								elseif($status == "zero")
									$profit = "Возврат";
								$symbol = $symbol == "XAUUSD" ? "GOLD" : $symbol;
								$symbol = str_replace("/", "", $symbol);
								$get_id = -1;
								$g = $mysqli->query("SELECT `user_id`, `id`, `symbol`, `status` FROM `binomo_history` WHERE `status` = 'signal' AND `user_id` = '{$user['id']}' AND `symbol` = '{$symbol}' AND `date` < '{$date}'  ORDER BY `id` ASC LIMIT 1");
								if($g->num_rows == 1) {
									$g = $mysqli->assoc($g);
									$get_id = $g['id'];
									$mysqli->query("UPDATE `binomo_history` SET `profit` = '{$profit}', `status` = '{$status}', `rate` = '{$rate}', `date` = CONCAT(`date`, '<br/>', '{$date}') WHERE `id` = '{$get_id}' AND `user_id` = '{$user['id']}'");
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
			elseif($action == "percents") {
				$answer = array(
					"code" => "error"
				);
				$percents = $mysqli->query("SELECT `binomo_code`, `binomo` FROM `quotes_list`");
				if($percents->num_rows) {
					$answer['code'] = "success";
					$answer['percents'] = array();
					$percent = $mysqli->assoc($percents);
					do {
						$answer['percents'][$percent['binomo_code']] = $percent['binomo'];
					}
					while($percent = $mysqli->assoc($percents));
				}
				echo json_encode($answer);
			}
			elseif($action == "open-deal" && isset($_POST['demo']) && isset($_POST['minutes']) && isset($_POST['rate']) && isset($_POST['position']) && isset($_POST['symbol'])) {
				$demo = $adds->siftText($_POST['demo']);
				$symbol = $adds->siftText($_POST['symbol']);
				$minutes = $adds->toInteger($_POST['minutes']);
				$rate = $adds->toInteger($_POST['rate']);
				$position = $adds->siftText($_POST['position']);
				if(isset($_SESSION['binomo'])) {
					$path = $adds->siftText($_SESSION['binomo']);
					$set_rate = $this->setRate($minutes, $rate, $symbol, $position, $demo, $path);
					if($set_rate['code'] == "success") {
						exit("success");
					}
					else {
						exit($set_rate['code']);
					}
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
	public function setRate($time_minutes, $summ, $pair, $position, $demo, $path) {
		$returnData = array(
			"code" => "error"
		);
		$demo = $demo == ":demo" ? "true" : "false";
    $time_minutes++;
    if(file_exists(dirname(__FILE__)."/binomo/{$path}.txt")) {
      $time = time() * 1000;
      $exp = date("Y-m-d H:i") . ":00";
      $exp_lost = 0;
      if(date("s") > 0 && $time_minutes == 5 && $time_minutes == 6)
        $exp_lost = -60;
      $exp = strtotime($exp) + (60 * $time_minutes) + $exp_lost;
      $amount = $summ * 100;
      $position = $position == "down" ? "put" : "call";
      $send = curl_init();
      curl_setopt($send, CURLOPT_URL, "https://binomo.com/api/deals/create?amount={$amount}&asset={$pair}&created_at={$time}&demo={$demo}&device=web&expire_at={$exp}&locale=ru&option_type=turbo&source=mouse&trend={$position}&trusted=true");
      curl_setopt($send, CURLOPT_HEADER, 0);
      curl_setopt($send, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($send, CURLOPT_FOLLOWLOCATION, 0);
      curl_setopt($send, CURLOPT_CONNECTTIMEOUT, 30);
      curl_setopt($send, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($send, CURLOPT_COOKIEFILE, dirname(__FILE__)."/binomo/{$path}.txt");
      $answer_text = curl_exec($send);
      $answer = json_decode($answer_text);

      if(!$answer->success) {
      	if($answer->errors[0]->code == "deal_amount_balance")
      		$returnData['code'] = "balance";
      	if($answer->errors[0]->code == "deal_amount_max")
      		$returnData['code'] = "deal_amount_max";
      	return $returnData;
      }

      $lasttime = $exp - time();

      $returnData['code'] = 'success';
      $returnData['lasttime'] = $lasttime;
      return $returnData;
    }
    else {
    	$returnData['code'] = 'auth_error';
      return $returnData;
    }
  }
}
?>