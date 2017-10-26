<?php
class Buy extends Core {
	public function getTitle() {}
	public function getContent() {
		$this->changeLauncher("clean");
		$adds = new Additions();
		$action = '';
		if(isset($_POST['action'])) {
			$action = $_POST['action'];
		}
		global $mysqli;
		$date = date("Y-m-d");
		if($adds->isAuth()) {
			$user = $adds->getUserData();
			if($action == "redirect") {
				if(isset($_POST['summ']) && isset($_POST['package']) && isset($_POST['system']) && isset($_POST['pay-system'])) {
					$summ = $adds->toInteger($_POST['summ']);
					$package_id = $adds->toInteger($_POST['package']);
					$system = $adds->siftText($_POST['system']);
					$pay_system = $adds->siftText($_POST['pay-system']);
					$promo = 0;
					if(isset($_POST['promo']) && $adds->set("bonuses") == "1") {
						$promo_code = $adds->siftText($_POST['promo']);
						$bonus = $mysqli->query("SELECT `key`, `percent` FROM `bonuses` WHERE `key` = '{$promo_code}' LIMIT 1");
						if($bonus->num_rows) {
							$bonus = $mysqli->assoc($bonus);
							$promo = $bonus['percent'];
						}
					}
					$package = $mysqli->query("SELECT * FROM `packages` WHERE `id` = '{$package_id}' LIMIT 1");
					if($package->num_rows == 1) {
						$package = $mysqli->assoc($package);
						if($package['price'] == $summ) {
							$course = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'course' LIMIT 1");
							if($course->num_rows == 1) {
								$course = $mysqli->assoc($course);
								$course = $adds->toInteger($course['value']);
								if($package['type'] != "vip" && $package['type'] != "vip1") {
									$promo = 0;
								}
								$summ = $summ - $summ * $promo / 100;
								$summ_conv = $summ * $course;
								$date_full = date("Y-m-d H:i:s");
								$mysqli->query("INSERT INTO `orders` (`summ`, `date`, `user_id`, `status`, `package_id`, `bonus`) VALUES ('{$summ}', '{$date_full}', '{$user['id']}', '0', '{$package_id}', '{$promo}')");
								$last_id = $mysqli->query("SELECT `id`, `user_id`, `date` FROM `orders` WHERE `date` = '{$date_full}' AND `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT 1");
								if($last_id->num_rows == 1) {
									$last_id = $last_id->fetch_assoc();
									$last_id = $last_id['id'];
									$time = str_replace(" 00:00", "", $adds->timeleft($package['time']));
									$desc_text = "Покупка доступа на {$time} ({$package['type']})";
									if($system == 'robokassa') {
										$pays_tmps = array(
											"qiwi" => "&IncCurrLabel=Qiwi50OceanRM&IncCurrGroup=EMoney",
											"walletone" => "&IncCurrLabel=W1OceanR&Group=EMoney",
											"elecsnet" => "&IncCurrLabel=ElecsnetWalletR&Group=EMoney",
											"unistream" => "&IncCurrLabel=W1UniMoneyOceanR&Group=EMoney",
											"visamastercard" => "&IncCurrLabel=BANKOCEAN2R&Group=BankCard",
											"alfabank" => "&IncCurrLabel=AlfaBankOceanR&Group=Bank",
											"rsb" => "&IncCurrLabel=RussianStandardBankR&Group=Bank",
											"mts" => "&IncCurrLabel=MobicomMtsR&Group=Mobile",
											"beeline" => "&IncCurrLabel=MobicomBeelineR&Group=Mobile",
											"t-qiwi" => "&IncCurrLabel=Qiwi50OceanRM&Group=Terminals",
											"t-elecsnet" => "&IncCurrLabel=TerminalsElecsnetOceanR&Group=Terminals",
											"robokassa" => ""
										);
										if(isset($pays_tmps[$pay_system])) {
											$pays_tmps = $pays_tmps[$pay_system];
										}
										else {
											$pays_tmps = "";
										}
										$inv_id = $last_id;
										$inv_desc = $desc_text;
										$mrh_login = ROBOKASSA_LOGIN;
										$mrh_pass1 = ROBOKASSA_PASSWORD;
										$out_summ  = $summ_conv;
										$crc  = md5("{$mrh_login}:{$out_summ}:{$inv_id}:{$mrh_pass1}:Shp_item={$package_id}");
										$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin={$mrh_login}&".
											"MerchantLogin={$mrh_login}&InvId={$inv_id}&OutSum={$out_summ}&Desc={$inv_desc}&SignatureValue={$crc}&Shp_item={$package_id}{$pays_tmps}";
									}
									elseif($system == 'interkassa') {
										$ik_co_id = INTERKASSA_KEY;
                                                                    		$ik_pm_no = $last_id;
										$ik_am = $summ_conv;
										$ik_cur = "RUB";
										$ik_desc = $desc_text;
										$ik_inv_id = $package_id;
										$ik_sign = mb_strtoupper(md5("{$ik_co_id}/{$ik_pm_no}/{$ik_inv_id}/success"));
										$url = "https://sci.interkassa.com/?ik_co_id={$ik_co_id}&ik_pm_no={$ik_pm_no}&ik_am={$ik_am}&ik_cur={$ik_cur}&ik_desc={$ik_desc}&ik_inv_id={$ik_inv_id}&ik_sign={$ik_sign}#/paysystem/{$pay_system}";
									}
									elseif($system == "ooopay") {
										$ik_co_id = OOOPAY_ID;
										$ik_pm_no = $last_id;
										$ik_am = $summ_conv;
										$ik_cur = "RUR";
										$ik_desc = $desc_text;
										$ik_inv_id = $package_id;
										$key = OOOPAY_KEY;
										$ik_sign = md5("{$ik_co_id}{$ik_am}{$ik_pm_no}{$ik_cur}{$key}");
										$url = "https://www.ooopay.org/page/payments/?m={$ik_co_id}&amount={$ik_am}&order_id={$ik_pm_no}&lang=ru¤cy={$ik_cur}&sign={$ik_sign}&pcur={$pay_system}";
									}
									else {
										exit("error");
									}
									echo $url;
								}
								else {
									echo "error";
								}
							}
							else {
								echo 'error';
							}
						}
						else {
							echo 'error';
						}
					}
					else {
						echo 'error';
					}
				}
				else {
					echo 'error';
				}
			}
			elseif($action == "checkpromo" && isset($_POST['key'])) {
				$key = $adds->siftText($_POST['key']);
				$bonus = $mysqli->query("SELECT `key`, `percent` FROM `bonuses` WHERE `key` = '{$key}' LIMIT 1");
				if($bonus->num_rows) {
					$bonus = $mysqli->assoc($bonus);
					echo $bonus['percent'];
				}
				else {
					echo "error";
				}
			}
		}
		else {
			echo "auth";
		}
	}
}
?>