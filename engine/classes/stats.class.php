<?php
class Stats extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Статистика сервиса";
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
        $this->templateEdit("title_content", "Подробная статистика сервиса <span data-toggle='modal' data-target='#opan-calculate-rate' class='glyphicon glyphicon-piggy-bank calculate-rate'></span>");
        $user = $adds->getUserData();
        $data = new Reader("default");
        $data->view("cabinet/stats");
        $sbox = "";
        if( ($user['timeleft'] > 0 || $user['time_vip'] > 0 ) && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
            $stats = $mysqli->query("SELECT * FROM `signals_stats` WHERE `date` = '{$date}' AND `bid4` = '0' ORDER BY `id` DESC LIMIT 30");
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
            $data->change("stats", $sbox);
        }
        else {
            if($user['timeleft'] <= 0 && $user['time_vip'] <= 0) {
                $lock = new Reader("default");
                $lock->view("cabinet/lock");
                $lock->change("uri", URI);
                echo $lock->show();
            }
            elseif(date("l") == "Saturday" ||  date("l") == "Sunday") {
                $output = new Reader("default");
                $output->view("cabinet/output");
                echo $output->show();
            }
            else {
                $confirm = new Reader("default");
                $confirm->view("cabinet/confirm");
                $confirm->change("uri", URI);
                echo $confirm->show();
            }
            $data->change("stats", "");
        }
        echo $data->show();
    }
}
?>