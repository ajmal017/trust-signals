<?php
class Home_news extends Core {
	public function getTitle() {
		echo "Новости сайта";

	}
	public function getContent() {
		$date = date("Y-m-d");
		$this->changeLauncher("ospage");
		$adds = new Additions();
		if($adds->isAuth()) {
			$user = $adds->getUserData();
		}
		else {
			$user = NULL;
		}
		if(1) {
			global $mysqli;
			$this->templateEdit("description", "Свежые обновления и новинки на trust-signals.com");
			$this->templateEdit("page_name", "Новости");
			$last = $mysqli->query("SELECT `date`, `title`, `id` FROM `home_news`ORDER BY `id` DESC LIMIT 3");
			$last_news = "";
			if($last->num_rows) {
				$l = $mysqli->assoc($last);
				do {
					$title = $l['title'];
					if(mb_strlen($title) > 50) {
						$title = mb_substr($title, 0, 50, "UTF-8") . "...";
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
			$limit = 10;
			$str_res = "";
			$foundkey = 0;
			if(isset($_GET['id'])) { $foundkey = 1; }
			if($foundkey) {
				$id = $adds->toInteger($_GET['id']);
				$search_atricle = $mysqli->query("SELECT * FROM `home_news` WHERE `id` = '{$id}' LIMIT 1");
				if($search_atricle->num_rows == 0) $foundkey = 0;
			}
			if($foundkey) {
				$row = $mysqli->assoc($search_atricle);
				$data = new Reader("default");
				$data->view("ospage/open");
				$data->change("title", $row['title']);
				$data->change("text", $row['text']);
				$data->change("id", $row['id']);
				$data->change("img", $row['img']);
				$data->change("date", $row['date']);
				$data->change("uri", URI);
			}
			else {
				$data = new Reader("default");
				$data->view("ospage/awrap");
				$strs = $mysqli->query("SELECT `date`, `type`, `title`, `img`, `id`, `text` FROM `home_news`ORDER BY `id` DESC LIMIT {$limit}");
				$am = $mysqli->query("SELECT `date`, `type`, `title`, `img`, `id`, `text` FROM `home_news`")->num_rows;
				if($strs->num_rows > 0) {
					$row = $mysqli->assoc($strs);
					$str_res = "<div class='news-full-box'><div id='strategies-list'>";
					do {
						$desc = strip_tags($row['text']);
						if(strlen($desc) > 350) {
							$desc = mb_substr($desc, 0, 350).'...';
						}
						$tmp = new Reader("default");
						$tmp->view("ospage/articles");
						$tmp->change("title", $row['title']);
						$tmp->change("description", $desc);
						$tmp->change("id", $row['id']);
						$tmp->change("img", $row['img']);
						$tmp->change("uri", URI);
						$tmp->change("date", $row['date']);
						$str_res .= $tmp->show();
					}
					while($row = $mysqli->assoc($strs));
					$str_res .= "</div>";
					if($am > $limit) {
						$wrap_load = new Reader("default");
						$wrap_load->view("ospage/load");
						$str_res .= "<div id='load-more'>".$wrap_load->show()."</div>";
					}
					$str_res .= "</div>";
				}
				else {
					$str_res = new Reader("default");
					$str_res->view("cabinet/infobox");
					$str_res->change("text", "Список новостей в данный момент пуст");
					$str_res = $str_res->show();
				}
			}

			$str_cabinet = $str_res;
			$data->change("news", $str_cabinet);
			echo $data->show();
		}
		else {
			$adds->redirect(URI."/cabinet/");
		}
	}
}
?>