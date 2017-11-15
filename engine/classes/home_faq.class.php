<?php
class Home_faq extends Core {
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
			$this->templateEdit("description", "Ответы на часто задаваемые вопросы");
			$this->templateEdit("page_name", "FAQ");
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
			$fq = $mysqli->query("SELECT `title`, `id`, `message` FROM `faq`");
			if($fq->num_rows > 0) {
				$f = $mysqli->assoc($fq);
				do {
					$inf = new Reader("default");
					$inf->view("cabinet/faq");
					$inf->change("id", $f['id']);
					$inf->change("title", $f['title']);
					$inf->change("message", $f['message']);
					echo $inf->show();
				}
				while($f = $mysqli->assoc($fq));
			}
			else {
				$inf = new Reader("default");
				$inf->view("cabinet/infobox");
				$inf->change("text", "Страница \"Ответы на частые вопросы\" пустая");
				echo $inf->show();
			}
		}
		else {
			$adds->redirect(URI."/cabinet/");
		}
	}
}
?>