<?php
	class OHome extends Core {
		public function getTitle() {
			echo "Trust Signals - Лучшие сигналы для бинарных и турбо опционов";
		}
		public function getContent() {
			global $mysqli;
			$this->changeLauncher("home_orange");
			$adds = new Additions();
			$this->templateEdit("URI", URI);
			if($adds->isAuth()) {
				$user = $adds->getUserData();
				$this->templateEdit("user_img", $user['img']);
				$this->templateEdit("user_name", $user['name']);
			}
			$wtime = 20;
            $datetime1 = date_create('2014-06-01');
            $datetime2 = date_create(date("Y-m-d"));
            $interval = date_diff($datetime1, $datetime2);
            $wtime =  $interval->days;
            $wpersent = rand(81, 86);
            $mprofit = rand(150, 230);
            $ausers = $adds->usersAmound();


            /* NEWS */
            $news = $mysqli->query("SELECT `img`, `title`, `id` FROM `home_news` ORDER BY `id` DESC LIMIT 6");
            if($news->num_rows > 0) {
                $slides = "";
                $n_row = $mysqli->assoc($news);
                do {
                    $sl = new Reader("default");
                    $sl->view("orange/news");
                    $sl->change("id", $n_row['id']);
                    $sl->change("title", $n_row['title']);
                    $sl->change("img", $n_row['img']);
                    $slides .= $sl->show();
                }
                while($n_row = $mysqli->assoc($news));
                $this->templateEdit("news", $slides);
            }
            else {
                $this->templateEdit("news", "");
            }


            $this->templateEdit("URI", URI);
            $this->templateEdit("wtime", $wtime);
            $this->templateEdit("wpersent", $wpersent);
            $this->templateEdit("ausers", $ausers);
            $this->templateEdit("mprofit", $mprofit);
		}
	}
?>