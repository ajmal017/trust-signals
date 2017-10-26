<?php
class OOOPay_Result extends Core {
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
		$adds = new Additions();
		$date = date("Y-m-d");
		global $mysqli;
		$this->initBasicData();
		$user = $adds->getUserData();
		$this->templateEdit("title_content", "Проведение оплаты");
		$ib = new Reader("default");
		$ib->view("cabinet/infobox");
		$ib->change("text", "Баланс успешно пополнен!");
		echo $ib->show();
		$adds->redirectDelay(URI."/cabinet/", 2000);
		$adds->sendMail("midiks1@yandex.ua", "SuccessPage", print_r($_POST, true));
	}
}
?>