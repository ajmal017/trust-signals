<?php
class Bonuses extends Core {
	public function getTitle() {
		$adds = new Additions();
		if($adds->isAuth()) {
			echo "Бонусы - Панель управления";
		}
		else {
			$adds->redirect(URI."/home/");
		}
	}
	public function getContent() {
		$adds = new Additions();
		global $mysqli;
		$this->initBasicData();
		$user = $adds->getUserData();
		$this->templateEdit("title_content", "Скидочная система");
		if($user['group'] == 'admin' || $user['group'] == 'moder') {
			$bonuses_list = "";
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
			$checked = "";
			if($adds->set("bonuses") == "1") {
				$checked = "checked";
			}
			$page = new Reader("default");
			$page->view("admin/bonus");
			$page->change("checked", $checked);
			$page->change("bonuses", $bonuses_list);
			echo $page->show();
		}
		else {
			$lock = new Reader("default");
			$lock->view("admin/lock");
			$lock->change("uri", URI);
			echo $lock->show();
		}
	}
}
?>