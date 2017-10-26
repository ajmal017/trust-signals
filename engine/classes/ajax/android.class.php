<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost');
header("Content-Security-Policy: default-src 'self' data: gap: cdvfile: https://ssl.gstatic.com; style-src 'self' 'unsafe-inline'; media-src *");
class Android extends Core {
	public function getTitle() {}
	public function getContent() {
		$this->changeLauncher("clean");
		$adds = new Additions();
		$date = date("Y-m-d");
		global $mysqli;
		if(isset($_POST['action'])) {
			$action = $adds->siftText($_POST['action']);
		}
		else {
			exit("Without params");
		}
		$ver = "";
		if(isset($_POST['v'])) {
			$ver = $adds->siftText($_POST['v']);
		}
		if($action == "auth" && isset($_POST['email']) && isset($_POST['password'])) {
			$email = $adds->siftText($_POST['email']);
			$pass = $adds->siftText($_POST['password']);
			$answer = array(
				"response" => "",
				"token" => array()
			);
			$res = $mysqli->query("SELECT * FROM `users` WHERE `email` = '{$email}' AND `password` = '{$pass}'");
			if($res->num_rows == 1) {
				$token = $mysqli->assoc($res);
				$answer['response'] = "success";
				$answer['token'] = $token;
			}
			else {
				$answer['response'] = "fail";
				$answer['token'] = "";
			}
			echo json_encode($answer);
		}
		elseif($action == "send" && isset($_POST['password']) && isset($_POST['email'])) {
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `confirm`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				if(isset($_POST['subject']) && isset($_POST['text'])) {
					$subject = $adds->siftText($_POST['subject']);
					$text = $adds->siftText($_POST['text']);
					if(!empty($text) && !empty($subject)) {
						$date = date("Y-m-d");
						$date_time = date("Y-m-d H:i:s");
						$mysqli->query("INSERT INTO `support` (`text`, `subject`, `user_id`, `email`, `date`) VALUES ('{$text}', '{$subject}', '{$user['id']}', '{$user['email']}', '{$date_time}')");
						$mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`, `side`) VALUES ('{$user['id']}', '{$text}', '{$date}', '1', '1')");
						echo "success";
					}
					else {
						echo 'empty';
					}
				}
				else {
					echo 'data';
				}
			}
		}
		elseif($action == "last" && isset($_POST['pair'])) {
			$pair = $adds->siftText($_POST['pair']);
			$last = $mysqli->query("SELECT `symbol`, `bid`, `id` FROM `quotes` WHERE `symbol` = '{$pair}' ORDER BY `id` DESC LIMIT 1");
			if($last->num_rows > 0) {
				$last = $mysqli->assoc($last);
				echo $last['bid'];
			}
			else {
				echo "0";
			}
		}
		elseif($action == 'news') {
			$client = new SoapClient('http://client-api.instaforex.com/soapservices/Calendar.svc?wsdl');
			$lang = "Ru";
			if(isset($_POST['lang'])) {
				$lang = $adds->siftText($_POST['lang']);
				$lang = strtoupper($lang[0]) . $lang[1];
			}

			$parameters = array(
				'lang' => $lang,
				'account' => array( 
					'login' => "8728366",
					'password' => "sosaba03"
				) 
			); 
			$result = (array)$client->GetCalendar($parameters);
			$result = $result["GetCalendarResult"]->Event;
			$count = count($result);
			$res_sort = array();
			for($i = 0; $i < $count; $i++) {
				$data = (array)$result[$i];
				if(!empty($data['Name']) &&
				   !empty($data['ReleaseTimestamp']) &&
				   !empty($data['Actual']) &&
				   !empty($data['Importance']) &&
				   !empty($data['Country'])
				) {
					if(gmdate("m-d", $data['ReleaseTimestamp']) >= date("m-d"))
						$res_sort[] = $data;
				}
			}
			$by = 'ReleaseTimestamp';
			usort($res_sort, function($first, $second) use( $by  ) {
				if ($first[$by]>$second[$by]) { return 1; }
				elseif ($first[$by]>$second[$by]) { return -1; }
				return 0;
			});

			$box = "";
			for($i = 0; $i < count($res_sort); $i++) {
				$data = $res_sort[$i];
				$tmp = new Reader("android".$ver);
				$tmp->view("news");
				$tmp->change("int", $data['Actual']);
				$tmp->change("desc", $data['Name']);
				$tmp->change("country", strtoupper($data['Country']));

				$flags = array(
					"eu" => "http://bit.ly/1nMygQ7",
					"ja" => "http://bit.ly/1PjZ8Od",
					"uk" => "http://bit.ly/1mBV03R"
				);

				if(!isset($flags[$data['Country']])) {
					$low = "http://flags.fmcdn.net/data/flags/normal/". $data['Country'] .".png";
				}
				else {
					$low = $flags[$data['Country']];
				}
				$tmp->change("low", $low);
				$power = "<i class='fa fa-user'></i> ";
				if($data['Importance'] == "Middle") {
					$power .= $power;
				}
				elseif($data['Importance'] == "High") {
					$power .= $power. " " . $power;
				}
				$tmp->change("pow", $power);
				$tmp->change("time", gmdate("H:i:s", $data['ReleaseTimestamp']));
				$tmp->change("date", gmdate("m-d", $data['ReleaseTimestamp']));
				$box .= $tmp->show();
			}
			echo $box;
		}
		elseif($action == 'get-news') {
			$news = $mysqli->query("SELECT * FROM `economic_news` ORDER BY `date` DESC");
			$news_box = array(
				"id" => 0,
				"text" => ""
			);
			if($news->num_rows > 0) {
				$news_a = $mysqli->assoc($news);
				do {
					$timeleft = round(($news_a['date'] - strtotime("now")) / 60);
					if($timeleft >= 1 && $timeleft <= 15) {
						$news_a['date'] = date("Y-m-d H:i:s", $news_a['date']);
						$textNews = "Ожидайте новость через <span>{$timeleft}</span> минут";
						if($ver != "") {
							$textNews = "{word_67} <span>{$timeleft}</span> {word_68}";
						}
						$news_box = array(
							"id" => $news_a['id'],
							"text" => $textNews
						);
						break;
					}
				}
				while($news_a = $mysqli->assoc($news));
			}
			echo json_encode($news_box);
		}
		elseif($action == 'get' && isset($_POST['power']) && isset($_POST['password']) && isset($_POST['email'])) {
			$ver = "";
			if(isset($_POST['v'])) {
				$ver = $adds->siftText($_POST['v']);
			}
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$power = $adds->toInteger($_POST['power']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `confirm`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				$answer = array(
					"response" => "",
					"content" => ""
				);
				if($user['confirm'] == '1') {
					if(date("l") != "Saturday" &&  date("l") != "Sunday") {
						if($adds->toInteger($user['time_vip']) > 0) {
							$quotes_list = array();
							$qlist = $mysqli->query("SELECT `translate_name`,`user_id` FROM `users_quotes` WHERE `user_id` = '{$user['id']}'");
							if($qlist->num_rows > 0) {
								$qbase = $mysqli->assoc($qlist);
								do {
									$symbol_name = $mysqli->query("SELECT `name`, `translate` FROM `quotes_list` WHERE `translate` = '{$qbase['translate_name']}' LIMIT 1");
									if($symbol_name->num_rows == 1) {
										$sname = $mysqli->assoc($symbol_name);
										$sname = $sname['name'];
										$quotes_list[$qbase['translate_name']] = $sname;
										$answer[$qbase['translate_name']] = array("answer" => "empty", "tmp" => "");
									}
								}
								while($qbase = $mysqli->assoc($qlist));
							}

							foreach($quotes_list as $key => $value):
								$content = "";
								$money = 0;
								$type = 1;
								$buff = array();
								$position = "";
								$power_interest = 0;
								$date_plus = new DateTime($date);
								$date_plus->modify("+1 Day");
								$date_plus = $date_plus->format("Y-m-d");

								$quote = $mysqli->query("SELECT * FROM `quotes` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' ) ORDER BY `id` DESC");
								if($quote->num_rows > 8) {
									$q = $mysqli->assoc($quote);
									do {
										array_push($buff, $q);
									}
									while($q = $mysqli->assoc($quote));

									for($i = 0; $i < count($buff); $i++):
										if(isset($buff[$i+8])) {
											$signals = array($buff[$i]['bid'], $buff[$i + 1]['bid'], $buff[$i + 2]['bid'], $buff[$i + 3]['bid'], $buff[$i + 4]['bid'], $buff[$i + 5]['bid'], $buff[$i + 6]['bid'], $buff[$i + 7]['bid'], $buff[$i + 8]['bid']);
											if($signals[0] > $signals[1] && $signals[1] > $signals[2]) {
												$power_interest = 25;
												$position = "down";
												$money = "1-3$";
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3]) { $power_interest = 35; $money = "1-3$"; }
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4]) { $power_interest = 45; $money = "3-6$"; }
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5]) { $power_interest = 65; $money = "6-9$"; }
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]) { $power_interest = 75; $money = "9-15$"; }
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]) { $power_interest = 85; $money = "15-20$"; }
												if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]  && $signals[7] > $signals[8]) { $power_interest = rand(92, 99); $money = "20-30$";  }
												if(isset($power)) {
													if($power_interest >= $power || ($power == 100 && $power_interest >= 92)) {
														break;
													}
													else {
														$position = "";
														$power_interest = 0;
													}
												}
												else {
													break;
												}
											}
											else {
												if($signals[0] < $signals[1] && $signals[1] < $signals[2]) {
													$power_interest = 25;
													$position = "up";
													$money = "1-3$";
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3]) { $power_interest = 35; $money = "1-3$"; }
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4]) { $power_interest = 45; $money = "3-6$"; }
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5]) { $power_interest = 65; $money = "6-9$"; }
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]) { $power_interest = 75; $money = "9-15$"; }
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]) { $power_interest = 85; $money = "15-20$"; }
													if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]  && $signals[7] < $signals[8]) { $power_interest = rand(92, 99); $money = "20-30$";  }
													if(isset($power)) {
														if($power_interest >= $power || ($power == 100 && $power_interest >= 92)) {
															break;
														}
														else {
															$position = "";
															$power_interest = 0;
														}
													}
													else {
														break;
													}
												}
											}
										}
										else {
											break;
										}
									endfor;
									if(!empty($position)) {
										$buff = $buff[$i];
										$date_time = (int)$buff['lasttime'];
										$time1 = gmdate("H:i:s", $date_time);
										$time2 = date('H:i:s', strtotime("+4 minutes", strtotime($time1)));
										$signal_data = new Reader("android" . $ver);
										$signal_data->view("pair");
										$signal_data->change("pos", $position);
										$signal_data->change("bid", $buff['bid']);
										$signal_data->change("name", $key);
										$signal_data->change("percent", $power_interest);
										$signal_data->change("pair", $value);
										$signal_data->change("time1", $time1);
										$signal_data->change("time2", $time2);
										$answer["content"][$key]['answer'] = "success";
										$answer["content"][$key]['tmp'] = $signal_data->show();
										$answer["content"][$key]['bid'] = $buff['bid'];
										$answer["content"][$key]['pos'] = $position;
									}
									else {
										$empty = new Reader("android" . $ver);
										$empty->view("empty");
										$empty->change("pair", $value);
										$empty->change("name", $key);
										$answer["content"][$key]['answer'] = "empty";
										$answer["content"][$key]['tmp'] = $empty->show();
										$answer["content"][$key]['bid'] = 0;
										$answer["content"][$key]['pos'] = 0;
									}
								}
								else {
									$empty = new Reader("android" . $ver);
									$empty->view("empty");
									$empty->change("pair", $value);
									$empty->change("name", $key);
									$answer["content"][$key]['answer'] = "empty";
									$answer["content"][$key]['tmp'] = $empty->show();
									$answer["content"][$key]['bid'] = 0;
									$answer["content"][$key]['pos'] = 0;
								}
							endforeach;
							$answer['response'] = "success";
						}
						else {
							$answer['response'] = "time";
							$answ_load = new Reader("android" . $ver);
							$answ_load->view("errors/time");
							$answ_load->change("email", $email);
							$answ_load->change("password", $password);
							$answer['content'] = $answ_load->show();
						}
					}
					else {
						$answer['response'] = "week";
						$answ_load = new Reader("android" . $ver);
						$answ_load->view("errors/week");
						$answer['content'] = $answ_load->show();
					}
				}
				else {
					$answer['response'] = "confirm";
					$answ_load = new Reader("android" . $ver);
					$answ_load->view("errors/confirm");
					$answer['content'] = $answ_load->show();
				}
				echo json_encode($answer);
			}
			else {
				echo "AuthError";
			}
		}
		elseif($action == "add-match-to-list" && isset($_POST['password']) && isset($_POST['email'])) {
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				if(isset($_POST['match'])) {
					$match = $adds->siftText($_POST['match']);
					$m_r = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
					$m2_r = $mysqli->query("SELECT `translate` FROM `quotes_list` WHERE `translate` = '{$match}' LIMIT 1");
					if($m_r->num_rows == 0 && $m2_r->num_rows == 1) {
						$mysqli->query("INSERT INTO `users_quotes` (`translate_name`, `user_id`) VALUES ('{$match}', '{$user['id']}')");
						echo "success";
					}
				}
			}
			else {
				echo "AuthError";
			}
		}
		elseif($action == "remove-match-to-list" && isset($_POST['password']) && isset($_POST['email'])) {
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				if(isset($_POST['match'])) {
					$match = $adds->siftText($_POST['match']);
					$m_r = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
					$m2_r = $mysqli->query("SELECT `translate` FROM `quotes_list` WHERE `translate` = '{$match}' LIMIT 1");
					if($m_r->num_rows > 0 && $m2_r->num_rows == 1) {
						$mysqli->query("DELETE FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
						echo "success";
					}
				}
			}
			else {
				echo "AuthError";
			}
		}
		elseif($action == 'pairs' && isset($_POST['password']) && isset($_POST['email'])) {
			$answer = array(
				"response" => "",
				"content" => array()
			);
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				$qs = $mysqli->query("SELECT `name`, `translate`, `id` FROM `quotes_list`");
				$answer['response'] = "success";
				if($qs->num_rows > 0) {
					$quotes = "";
					$row = $mysqli->assoc($qs);
					do {
						$checked = "0";
						$info_qt = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `user_id` = '{$user['id']}' AND `translate_name` = '{$row['translate']}' LIMIT 1");
						if($info_qt->num_rows > 0) {
							$checked = "1";
						}
						$answer['content'][] = array("name" => $row['name'], "status" => $checked, "translate" => $row['translate'], );
					}
					while($row = $mysqli->assoc($qs));
				}
				else {
					$answer['response'] = "empty";
					$answer['content'] = "Сервис на данный момент не работает с котировками";
				}
			}
			else {
				echo "AuthError";
			}
			echo json_encode($answer);
		}
		elseif($action == 'days') {
			global $pairs;
			$pair = "";

			if(isset($_POST['email']) && isset($_POST['password'])) {
				$email = $adds->siftText($_POST['email']);
				$password = $adds->siftText($_POST['password']);
				$us = $mysqli->query("SELECT `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
				if($us->num_rows == 1) {
					$u_data = $mysqli->assoc($us);
					if($adds->toInteger($u_data['time_vip']) <= 0) {
						$lock = new Reader("android" . $ver);
						$lock->view("errors/time");
						$pair = $lock->show();
						exit($pair);
					}
				}
				else {
					exit("USER DATA ERROR");
				}
			}

			if(date("l") == "Saturday" ||  date("l") == "Sunday") {
				$lock = new Reader("android" . $ver);
				$lock->view("errors/week");
				$pair = $lock->show();
				exit($pair);
			}

			foreach($pairs as $key => $value):
				$smb = $mysqli->query("SELECT * FROM `signals_days` WHERE `date` = '{$date}' AND `symbol` = '{$value}'");
				if($smb->num_rows > 0) {
					$smb_d = $mysqli->assoc($smb);
					$bid = $smb_d['bid'];
					$pos = $smb_d['pos'];
				}
				else {
					$xml = simplexml_load_file("http://quotes.instaforex.com/get_quotes.php?q={$key}");
					$xml = $xml->{'item'};
					$bid = $xml->{'bid'};
					$change24 = $xml->{'change24h'};
					$pos = $change24 < 0 ? "down" : "up";
				}
				if(date("H:i") < "17:30") {
					$is_desc = "Открывать сделку можно";
					if($ver != "") {
						$is_desc = "{word_40}";
					}
					$is = "check";
				}
				else {
					$is_desc = "Открывать сделку нельзя";
					if($ver != "") {
						$is_desc = "{word_41}";
					}
					$is = "close";
				}
				$p = new Reader("android" . $ver);
				$p->view("days");
				$p->change("symbol", $value);
				$p->change("bid", $bid);
				$p->change("pos", $pos);
				$p->change("desc_icon", $is);
				$p->change("desc", $is_desc);
				$pair .= $p->show();
			endforeach;
			echo $pair;
		}
		elseif($action == 'timeleft' && isset($_POST['password']) && isset($_POST['email'])) {
			$email = $adds->siftText($_POST['email']);
			$password = $adds->siftText($_POST['password']);
			$user = $mysqli->query("SELECT `id`, `email`, `password`, `time_vip`, `confirm` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}'");
			if($user->num_rows == 1) {
				$user = $mysqli->assoc($user);
				$time = $adds->toInteger($user['time_vip']);
				if(date("l") == "Saturday" ||  date("l") == "Sunday" || $user['confirm'] != '1') {
					$tm = $adds->timeleft($time);
					if($ver != "") {
						$tm = $adds->timeleft($time, 1);
					}
					exit($tm);
				}
				if($time - 1 > 0) {
					$mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` - 1 WHERE `id` = '{$user['id']}'");
					$tm = $adds->timeleft($time - 1);
					if($ver != "") {
						$tm = $adds->timeleft(($time - 1), 1);
					}
					echo $tm;
				}
				else {
					$mysqli->query("UPDATE `users` SET `time_vip` = '0' WHERE `id` = '{$user['id']}'");
					$tm = $adds->timeleft(0);
					if($ver != "") {
						$tm = $adds->timeleft(0, 1);
					}
					echo $tm;
				}
			}
			else {
				echo "AuthError";
			}
		}
	}
}
?>