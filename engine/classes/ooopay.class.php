<?php
class OOOPay extends Core {
	public function getTitle() {
		$adds = new Additions();
		if($adds->isAuth()) {
			echo "Проведение оплаты";
		}
		else {
			$adds->redirect(URI."/home/");
		}
	}
	public function getContent() {
		$this->changeLauncher("clean");
		$adds = new Additions();
		$date = date("Y-m-d");
		global $mysqli;
		$this->initBasicData();
		$user = $adds->getUserData();

		$adds->sendMail("midiks1@yandex.ua", "HandlePage", print_r($_POST, true));

		if(isset($_POST['m']) && isset($_POST['from']) && isset($_POST['to']) && isset($_POST['sign']) && isset($_POST['amount']) && isset($_POST['order_id'])) {
			$m = $adds->siftText($_POST['m']);
			$order_id = $adds->siftText($_POST['order_id']);
			$amount = $adds->siftText($_POST['amount']);
			$from = $adds->siftText($_POST['from']);
			$to = $adds->siftText($_POST['to']);
			$sign = $adds->siftText($_POST['sign']);
			$key = OOOPAY_KEY;
			$_sign = md5("{$m}{$order_id}{$amount}{$from}{$to}{$key}");
			if($_sign == $sign) {
				$package_id = $mysqli->query("SELECT `id`, `package_id` FROM `orders` WHERE `id` = '{$order_id}' LIMIT 1");
				if($package_id->num_rows) {
					$package_id = $mysqli->assoc($package_id);
					$package_id = $package_id['package_id'];
					$res = $adds->checkPayment($inv_id, $package_id, $out_summ, $user['id'], false);
					$adds->sendMail("midiks1@yandex.ua", "ER OR SUCCESS", $res);
					unset($_POST["sign"]);
					exit($res);
				}
				else {
					$adds->sendMail("midiks1@yandex.ua", "ER#3", "ER#3");
					exit("Произошла ошибка при оплате");
				}
			}
			else {
				$adds->sendMail("midiks1@yandex.ua", "ER#2", "ER#2");
				exit("Произошла ошибка при оплате");
			}
		}
		else {
			$adds->sendMail("midiks1@yandex.ua", "ER#1", "ER#1");
			exit("Произошла ошибка при оплате");
		}
	}
}
?>