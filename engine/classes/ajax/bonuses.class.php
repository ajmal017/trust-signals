<?php
class Bonuses extends Core {
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
		$user = $adds->getUserData();
		if($adds->isAuth() && $user['group'] == 'admin') {
			if($action == "module" && isset($_POST['val'])) {
				$val = $_POST['val'];
				if($val == '1') {
					$val = '1';
				}
				else {
					$val = '0';
				}
				$mysqli->query("UPDATE `settings` SET `value` = '{$val}' WHERE `title` = 'bonuses'");
				echo 'success';
			}
			elseif($action == "add" && isset($_POST['key']) && isset($_POST['percent'])) {
				$key = $adds->siftText($_POST['key']);
				$percent = $adds->toInteger($_POST['percent']);
				$check_key = $mysqli->query("SELECT `key` FROM `bonuses` WHERE `key` = '{$key}' LIMIT 1");
				if(!$check_key->num_rows) {
					$mysqli->query("INSERT INTO `bonuses` SET `key` = '{$key}', `percent` = '{$percent}'");
					$bonuses = $mysqli->query("SELECT * FROM `bonuses` ORDER BY `id` DESC");
					if($bonuses->num_rows) {
						$bonuses_off = "";
						$bonus = $mysqli->assoc($bonuses);
						do {
							$bonuses_off .= R::read("default", "admin/bonus_item", array(
								"id" => $bonus['id'],
								"key" => $bonus['key'],
								"percent" => $bonus['percent']
							));
						}
						while($bonus = $mysqli->assoc($bonuses));
						$bonuses_list = R::read("default", "admin/bonus_table", array(
							"bonuses" => $bonuses_off
						));
					}
					else {
						$bonuses_list = "Список бонусных ключей пуст";
					}
					echo $bonuses_list;
				}
				else {
					echo "key";
				}
			}
			elseif($action == "remove" && isset($_POST['id'])) {
				$id = $adds->toInteger($_POST['id']);
				$mysqli->query("DELETE FROM `bonuses` WHERE `id` = '{$id}'");
				$bonuses = $mysqli->query("SELECT * FROM `bonuses` ORDER BY `id` DESC");
				if($bonuses->num_rows) {
					$bonuses_off = "";
					$bonus = $mysqli->assoc($bonuses);
					do {
						$bonuses_off .= R::read("default", "admin/bonus_item", array(
							"id" => $bonus['id'],
							"key" => $bonus['key'],
							"percent" => $bonus['percent']
						));
					}
					while($bonus = $mysqli->assoc($bonuses));
					$bonuses_list = R::read("default", "admin/bonus_table", array(
						"bonuses" => $bonuses_off
					));
				}
				else {
					$bonuses_list = "Список бонусных ключей пуст";
				}
				echo $bonuses_list;
			}
		}
		else {
			echo "auth";
		}
	}
}
?>