<?php
class Home_stats extends Core {
	public function getTitle() {
		echo "Статистика";
	}
	public function getContent() {
		$date = date("Y-m-d");
		$this->changeLauncher("ospage");
        $this->templateEdit("URI", URI);
		$adds = new Additions();
		if($adds->isAuth()) {
			$user = $adds->getUserData();
            $this->templateEdit("user_img", $user['img']);
            $this->templateEdit("user_name", $user['name']);
		}
		else {
			$user = NULL;
		}
		if(1) {
			global $mysqli;
			$this->templateEdit("description", "Статистика сигналов за сегодня на EUR/USD");
			$this->templateEdit("page_name", "Статистика");
			$last = $mysqli->query("SELECT `date`, `title`, `id` FROM `home_news`ORDER BY `id` DESC LIMIT 3");
			$last_news = "";
			if($last->num_rows) {
				$l = $mysqli->assoc($last);
				do {
					$title = $l['title'];
					if(mb_strlen($title) > 50) {
						$title = mb_substr($title, 0, 50) . "...";
					}
					$ln = new Reader("default");
					$ln->view("ospage/mini");
					$ln->change("id", $l['id']);
					$ln->change("title", $title);
					$ln->change("date", $l['date']);
					$ln->change("uri", URI);
					$last_news .= $ln->show();
				}
				while($l = $mysqli->assoc($last));
			}
			else {
				$ln = new Reader("default");
				$ln->view("ospage/mini_empty");
				$last_news .= $ln->show();
			}
			$this->templateEdit("mini", $last_news);
			$stats = $mysqli->query("SELECT * FROM `signals_stats` WHERE `date` = '{$date}' AND `bid4` = '0' ORDER BY `symbol` ASC, `id` DESC LIMIT 30");
			if($stats->num_rows > 0) {
				$st = $mysqli->assoc($stats);
				do {
					$sv = new Reader("default");
					$sv->view("cabinet/stats_view");
					$pos = 'down';
					if($st['torb'] == 1) {
						$pos = 'up';
					}

					$bid1 = "";
					$bid2 = "";
					$bid3 = "";
					$bid4 = "";

					if($st['bid1']) {
						$status = 0;
						if($st['stop'] == '1') {
							$status = 1;
						}
						$label = new Reader("default");
						$label->view("cabinet/label");
						$label->change("text", $st['bid1']);
						$label->change("status", $status);
						$bid1 = $label->show();
					}
					if($st['bid2']) {
						$status = 0;
						if($st['stop'] == '2') {
							$status = 1;
						}
						$label = new Reader("default");
						$label->view("cabinet/label");
						$label->change("text", $st['bid2']);
						$label->change("status", $status);
						$bid2 = $label->show();
					}
					if($st['bid3']) {
						$status = 0;
						if($st['stop'] == '3') {
							$status = 1;
						}
						$label = new Reader("default");
						$label->view("cabinet/label");
						$label->change("text", $st['bid3']);
						$label->change("status", $status);
						$bid3 = $label->show();
					}
					if($st['bid4']) {
						$status = 0;
						if($st['stop'] == '4') {
							$status = 1;
						}
						$label = new Reader("default");
						$label->view("cabinet/label");
						$label->change("text", $st['bid4']);
						$label->change("status", $status);
						$bid4 = $label->show();
					}

					$time = $st['date'].' '.$st['time'];
					$sv->change("pos", $pos);
					$sv->change("date", $time);
					$sv->change("symbol", $st['symbol']);
					$sv->change("bid", $st['bid1']);
					$sv->change("bid1", $bid1);
					$sv->change("bid2", $bid2);
					$sv->change("bid3", $bid3);
					$sv->change("bid4", $bid4);
					$sbox .= $sv->show();
				}
				while($st = $mysqli->assoc($stats));
			}
			else {
				$ib = new Reader("default");
				$ib->view("cabinet/infobox");
				$ib->change("text", "В данный момент статистика сервиса пустая, возможно статистика была очищена в целях повышения продуктивности сервиса");
				$sbox = $ib->show();
			}
			$s = new Reader("default");
			$s->view("ospage/stats");
			$s->change("stats", $sbox);
			echo $s->show();
		}
		else {
			$adds->redirect(URI."/cabinet/");
		}
	}
}
?>