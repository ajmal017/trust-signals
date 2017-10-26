<?php
class WinPerc extends Core {
	public function getTitle() {}
	public function getContent() {
		$this->changeLauncher("clean");
		global $mysqli;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://olymptrade.com/platform/state");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$response = json_decode($response);
		foreach ($response->pairs->pairs as $key => $value) {
			$mysqli->query("UPDATE `quotes_list` SET `win` = '{$value->winperc}' WHERE `translate` = '{$key}'");
		}
		$data = curl_init();
    curl_setopt($data, CURLOPT_URL, "https://binomo.com/api/assets?locale=ru" );
    curl_setopt($data, CURLOPT_HEADER, 0);
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($data, CURLOPT_CONNECTTIMEOUT, 30);
    $data = json_decode(curl_exec($data));
    foreach ($data->data->assets as $value) {
			$mysqli->query("UPDATE `quotes_list` SET `binomo` = '{$value->payment_rate_turbo}' WHERE `binomo_code` = '{$value->ric}'");
		}
	}
}
?>