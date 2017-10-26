<?php
class Web extends Core {
	public function getTitle() {}
	public function getContent() {
		$this->changeLauncher("clean");
		$adds = new Additions();
		$action = '';
		if(isset($_POST['action'])) {
			$action = $_POST['action'];
		}
		global $mysqli;
		$web_demo = 0;
		$web = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo' LIMIT 1");
		if($web->num_rows == 1) {
			$web = $mysqli->assoc($web);
			$web_demo = $web['value'];
		}
		if($adds->isAuth()) {
			$user = $adds->getUserData();
			$date = date("Y-m-d");
			if($action == "update" && isset($_POST['algorithm']) && isset($_POST['symbols']) && ($user['time_vip'] > 0 || ($web_demo == "1" && $user['web_lasttime'] > 0 && $user['time_vip'] == 0)) && $user['confirm'] == '1' && (date("l") != "Saturday" &&  date("l") != "Sunday") || $user['group'] == "admin") {
				$answer = array();
				$algorithm = $adds->toInteger($_POST['algorithm']);
				$algorithm = $algorithm > 0 && $algorithm <= 4 ? $algorithm : 1;
				$symbols = strtolower($adds->siftText($_POST['symbols']));
				if(!empty($symbols)) {
					$symbols = explode(",", $symbols);
					$where = "WHERE";
					for($i = 0; $i < count($symbols); $i++) {
						$symbols[$i] = trim($symbols[$i]);
						$first = " OR ";
						if($i == 0)
							$first = " ";
						$symbol_full = strtoupper($symbols[$i]);
						$where .= "{$first}`translate` = '{$symbols[$i]}' OR `binomo_code` = '{$symbol_full}'";
					}
					$full_sql = "SELECT `translate`, `binomo_code` FROM `quotes_list` {$where}";
					if($mysqli->query($full_sql)->num_rows == count($symbols)) {
						foreach($symbols as $key):
							$res = 0;
							switch($algorithm) {
								case 1: 
									$res = $this->algByElly($key);
								break;
								case 2: 
									$res = $this->algByGet($key);
								break;
								case 3: 
									$res = $this->algByGetBid($key);
								break;
								case 4: 
									$res = $this->algByMix($key);
								break;
							}
							if($res !== 0)
								$answer[] = $res;
						endforeach;
						echo json_encode($answer);
					}
					else {
						echo "error_request";
					}
				}
			}
			elseif($action == "demo") {
				if($web_demo == 1 && $user['web_lasttime'] == 0 && $user['web_is'] == 1) {
					$web_start_time = 0;
            $st_sql = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo'");
            if($st_sql->num_rows == 1) {
                $st_sql = $st_sql->fetch_assoc();
                $st_sql = $st_sql['value'];
                if($st_sql == 1) {
                    $web_start_time = 30;
                    $s_time_get = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_time' LIMIT 1");
                    if($s_time_get->num_rows == 1) {
                        $s_time_get = $mysqli->assoc($s_time_get);
                        $web_start_time = $adds->toInteger($s_time_get['value']);
                    }
                }
            }
					$mysqli->query("UPDATE `users` SET `web_lasttime` = '{$web_start_time}', `web_is` = '0' WHERE `id` = '{$user['id']}'");
					exit("success");
				}
				else {
					exit("error");
				}
			}
		}
		else {
			echo "auth";
		}
	}
	public function algByMix($key) {
		$a = $this->algByGetBid($key);
		$b = $this->algByGet($key);
		if($b !== 0 && $a !== 0) {
			if($b['position'] == $a['position']) {
				return array(
					"symbol" => strtoupper($key),
					"position" => $a['position']
				);
			}
		}
		return 0;
	}
	public function algByGetBid($key) {
		global $mysqli;
		$key = $key == "XAUUSD" ? "Gold" : $key;
		$bids = $mysqli->query("SELECT `bid`, `symbol`, `id` FROM `quotes` WHERE REPLACE(`symbol`, '/', '') = '{$key}' ORDER BY `id` DESC LIMIT 10");
    if($bids->num_rows > 0) {
      $list = array();
      $bid = $mysqli->assoc($bids);
      do {
          $list[] = $bid['bid'];
      }
      while($bid = $mysqli->assoc($bids));

			if($list[3] > $list[2] && $list[2] > $list[1] && $list[1] > $list[0]){
				return array(
					"symbol" => strtoupper($key),
					"position" => "up"
				);
			}
		  else if($list[2] > $list[1] && $list[1] > $list[0]){
		  	return array(
					"symbol" => strtoupper($key),
					"position" => "down"
				);
		  }
		 	else if ($list[3] < $list[2] && $list[2] < $list[1] && $list[1] < $list[0]){
		 		return array(
					"symbol" => strtoupper($key),
					"position" => "down"
				);
		 	}
			else if ($list[2] < $list[1] && $list[1] < $list[0]){
				return array(
					"symbol" => strtoupper($key),
					"position" => "up"
				);
			}
			return 0;
    }
    return 0;
	}
	public function algByGet($key) {
		$id = strtolower($key);
		if($id == "xauusd")
			return 0;
		$list = array(
			"eurusd" => 1,
			"gbpusd" => 2,
			"gbpjpy" => 11,
			"euraud" => 15,
			"usdjpy" => 3,
			"usdcad" => 7,
			"usdchf" => 4,
			"nzdusd" => 8,
			"eurchf" => 10,
			"eurgbp" => 6,
			"gbpchf" => 12,
			"audusd" => 5
		);
		$id = $list[$id];
		$get = file_get_contents("http://tsw.ru.forexprostools.com/api.php?action=refresher&pairs={$id}&timeframe=60");
		$get = json_decode($get);
		$get = $get->{$id};
		$west = $get->technicalSummaryClass;
		if ($west == 'sell') {
			return array(
				"symbol" => strtoupper($key),
				"position" => "down"
			);
		}
		elseif ($west == 'buy') {
			return array(
				"symbol" => strtoupper($key),
				"position" => "up"
			);
		}
		else {
			return 0;
		}
	}
	public function algByElly($key) {
		global $mysqli;
		$down = 0;
		$up = 0;
		$error = "";
		$res_box = "";
		$t = date("m.d.Y | H:i");
		$time = time() + 10700;//было 10740
		$timedown = $time - 600;
		$params = array(
			'chartRequest' => array(
			'From' => $timedown,
			'To' => $time,
			'Symbol' => strtoupper($key),
			'Type' => "M1"
			)
		);
		$client = new SoapClient('http://client-api.instaforex.com/soapservices/charts.svc?wsdl');
		$test = (array)$client->GetCharts($params);
		$low0 = $test['GetChartsResult']->Candle[0]->Low;
		$low1 = $test['GetChartsResult']->Candle[1]->Low;
		$low2 = $test['GetChartsResult']->Candle[2]->Low;
		$low3 = $test['GetChartsResult']->Candle[3]->Low;
		$low4 = $test['GetChartsResult']->Candle[4]->Low;
		$low5 = $test['GetChartsResult']->Candle[5]->Low;
		$low6 = $test['GetChartsResult']->Candle[6]->Low;
		$low7 = $test['GetChartsResult']->Candle[7]->Low;
		$low8 = $test['GetChartsResult']->Candle[8]->Low;
		$low9 = $test['GetChartsResult']->Candle[9]->Low;

		$High0 = $test['GetChartsResult']->Candle[0]->High;
		$High1 = $test['GetChartsResult']->Candle[1]->High;
		$High2 = $test['GetChartsResult']->Candle[2]->High;
		$High3 = $test['GetChartsResult']->Candle[3]->High;
		$High4 = $test['GetChartsResult']->Candle[4]->High;
		$High5 = $test['GetChartsResult']->Candle[5]->High;
		$High6 = $test['GetChartsResult']->Candle[6]->High;
		$High7 = $test['GetChartsResult']->Candle[7]->High;
		$High8 = $test['GetChartsResult']->Candle[8]->High;
		$High9 = $test['GetChartsResult']->Candle[9]->High;
		$closed = $test['GetChartsResult']->Candle[9]->Close;
		$closed0 = $test['GetChartsResult']->Candle[0]->Close;
		$date = $test['GetChartsResult']->Candle[9]->Timestamp;
		$date0 = $test['GetChartsResult']->Candle[0]->Timestamp;
		$min = min($low0, $low1, $low2, $low3, $low4, $low5, $low6, $low7, $low8, $low9);
		$max = max($High0, $High1, $High2, $High3, $High4, $High5, $High6, $High7, $High8, $High9);

		$sql = "SELECT `result`, `id` FROM `elly` WHERE `symbol` = '{$key}' ORDER BY `id` DESC LIMIT 1";
		$result = $mysqli->query($sql);

		if (!$result) {
			$error = "Could not successfully run query ($sql) from DB";
		}

		$resultbd = "";

		if ($result->num_rows > 0) {
			$row = $mysqli->assoc($result);
			$resultbd = $row["result"];
		}
		$ressult = ($closed - $min) / ($max - $min) * 100;

		$pos = "";

		if(empty($closed)) {
			unset($ressult);
			return 0;
		}
		elseif($ressult > 98) {
			$pos = "down";
			$down = rand(81, 89);
			$up = 100 - $down;
			return array(
				"symbol" => strtoupper($key),
				"position" => "down"
			);
		}
		elseif($ressult > 76 && $ressult < 85 && $resultbd < $ressult) {
			$pos = "up";
			$up = rand(51, 59);
			$down = 100 - $up;
			return array(
				"symbol" => strtoupper($key),
				"position" => "up"
			);
		}
		elseif($ressult < 31 && $ressult > 18 && $resultbd > $ressult) {
			$pos = "down";
			$down = rand(51, 62); $up = 100-$down;
			return array(
				"symbol" => strtoupper($key),
				"position" => "down"
			);
		}
		elseif($ressult < 4) {
			$pos = "up";
			$up = rand(71, 79);
			$down = 100 - $up;
			return array(
				"symbol" => strtoupper($key),
				"position" => "up"
			);
		}
		$mysqli->query("INSERT INTO `elly` (`result`, `symbol`) VALUES ('{$ressult}', '{$key}')");
		return 0;
	}
}
?>