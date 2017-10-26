<?php
class Statistic extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Статистика - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Статистика");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
            $date = date("Y-m-d");
            $users = $mysqli->query("SELECT `id` FROM `users`")->num_rows;
            $pays = $mysqli->query("SELECT `pays`, `date` FROM `statistic` WHERE `date` = '{$date}' LIMIT 1");
            $prefit = $mysqli->query("SELECT `prefit`, `date` FROM `statistic` WHERE `date` = '{$date}' LIMIT 1");
            $views = $mysqli->query("SELECT `views`, `date` FROM `statistic` WHERE `date` = '{$date}' LIMIT 1");
            if($pays->num_rows == 1) { $pays = $mysqli->assoc($pays); $pays = $pays['pays']; }
            else { $pays = 0; }
            if($views->num_rows == 1) { $views = $mysqli->assoc($views); $views = $views['views']; }
            else { $views = 0; }
            if($prefit->num_rows == 1) { $prefit = $mysqli->assoc($prefit); $prefit = $prefit['prefit']; }
            else { $prefit = 0; }
            $prefit_last_month = 0;
            $prefit_this_month = 0;
            $this_date = date("Y-m");
            $last_date  = date("Y-m", strtotime("-1 month", strtotime($this_date)));
            $pts = $mysqli->query("SELECT `prefit`,  SUBSTRING(`date`, 1, 7) AS 'date' FROM `statistic`");
            if($pts->num_rows > 0) {
                $pts_row = $pts->fetch_assoc();
                do {
                    if($pts_row['date'] == $this_date)
                        $prefit_this_month += $pts_row['prefit'];
                    if($pts_row['date'] == $last_date)
                        $prefit_last_month += $pts_row['prefit'];
                }
                while($pts_row = $pts->fetch_assoc());
            }
            $basic = new Reader("default");
            $basic->view("admin/stats");
            $basic->change("users", $users);
            $basic->change("pays", $pays);
            $basic->change("prefit", $prefit);
            $basic->change("pays", $pays);
            $basic->change("views", $views);
            $basic->change("prefit_this_month", $prefit_this_month);
            $basic->change("prefit_last_month", $prefit_last_month);
            $page_num = 1;
            if(isset($_GET['num'])) {
                $page_num = $adds->toInteger($_GET['num']);
            }
            if($page_num == 0) {
                $page_num = 1;
            }
            $to = 0;
            $limit = 10;
            if($page_num > 1) {
                $to = $page_num * $limit - $limit;
            }
            $to = $adds->toInteger($to);
            $limit = $adds->toInteger($limit);
            $orders = $mysqli->query("SELECT * FROM `statistic` ORDER BY `id` DESC LIMIT {$to}, {$limit}");
            $amount = $mysqli->query("SELECT `id` FROM `statistic`")->num_rows;
            $ord = "";
            if($orders->num_rows > 0) {
                $order = $mysqli->assoc($orders);
                do {
                    $inf = new Reader("default");
                    $inf->view("admin/stats_rec");
                    $inf->change("id", $order['id']);
                    $inf->change("date", $order['date']);
                    $inf->change("pays", $order['pays']);
                    $inf->change("count_reg", $order['count_reg']);
                    $inf->change("views", $order['views']);
                    $inf->change("prefit", $order['prefit']);
                    $ord .= $inf->show();
                }
                while($order = $mysqli->assoc($orders));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "История в данный момент история пуста");
                $ord = "<tr><td colspan='5'>".$inf->show()."</td></tr>";
            }
            $basic->change("stats", $ord);
            $basic->change("page_nav", $adds->pageNav($page_num, $amount));
            echo $basic->show();
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