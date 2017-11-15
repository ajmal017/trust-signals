<?php
class Buy_elly extends Core {
	public function getTitle() {
		$adds = new Additions();
		if($adds->isAuth()) {
			echo "TrustSignals - Список пакетов";
		}
		else {
			$adds->redirect(URI."/home/");
		}
	}
	public function getContent() {
		$adds = new Additions();
		global $mysqli;
		$this->initBasicData();
		$this->changeLauncher("buy_elly");
		$user = $adds->getUserData();
		if($adds->isAuth()) {
			$p = $mysqli->query("SELECT * FROM `packages` WHERE `type` = 'vip1' ORDER BY `price` LIMIT 1");
			if($p->num_rows) {
				$f = $mysqli->assoc($p);
				$this->templateEdit("time", str_replace(" 00:00", "", $adds->timeleft($f['time'])));
				$this->templateEdit("id", $f['id']);
				$this->templateEdit("price", $f['price']);

				$systems = $mysqli->query("SELECT * FROM `pay_categories` ORDER BY `id` ASC");
				$pay_list = "";
				$pay_systems = "";
				if($systems->num_rows) {
					$system = $mysqli->assoc($systems);
					$isFirst = "active";
					do {
						$s = new Reader("default");
						$s->view("buy/li_system");
						$s->change("id", $system['id']);
						$s->change("name", $system['name']);
						$s->change("active", $isFirst);
						$pay_systems .= $s->show();
						$get_systems_list = "<p style='padding: 20px;'>Список систем для пополнения в данном разделе пуст</p>";
						$get_syst = $mysqli->query("SELECT * FROM `pay_systems` WHERE `category_id` = '{$system['id']}' AND `status` = '1'");
						if($get_syst->num_rows) {
							$get_systems_list = "";
							$g = $mysqli->assoc($get_syst);
							do {
								$gtmp = new Reader("default");
								$gtmp->view("buy/item_system");
								$gtmp->change("system", $g['system']);
								$gtmp->change("img", $g['img']);
								$gtmp->change("name", $g['name']);
								$get_systems_list .= $gtmp->show();
							}
							while($g = $mysqli->assoc($get_syst));
						}
						$s_wrap = new Reader("default");
						$s_wrap->view("buy/wrap_systems");
						$s_wrap->change("list", $get_systems_list);
						$s_wrap->change("id", $system['id']);
						$s_wrap->change("active", $isFirst);
						$pay_list .= $s_wrap->show();
						$isFirst = "";
					}
					while($system = $mysqli->assoc($systems));
				}

				$this->templateEdit("systems", $pay_systems);
				$this->templateEdit("list_systems", $pay_list);

			}
			else {
				$adds->redirect(URI."/home/");
			}
		}
		else {
			$adds->redirect(URI."/home/");
		}
	}
}
?>
