<?php
class Analysis extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Сигналы на конец дня";
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
        $this->templateEdit("title_content", "Сигналы на конец дня");

        if($user['timeleft'] > 0 && $user['confirm'] == '1' && ((date("l") != "Saturday" &&  date("l") != "Sunday"))) {

            global $pairs;
            $analysis = new Reader("default");
            $analysis->view("analysis/wrap");

            $am_pairs = count($pairs);
            $list_pairs = "";
            $analysis_history = array();
            $pairs_am = array();
            foreach($pairs as $key => $value):
                $list_pairs .= "<td>{$value}</td>\n";
            endforeach;

            $date = date("Y-m-d");

            $p_q = $mysqli->query("SELECT * FROM `analysis` WHERE `date` = '{$date}' ORDER BY `id` LIMIT 8");
            if($p_q->num_rows > 0) {
                $data = $mysqli->assoc($p_q);
                do {
                    $data = json_decode($data['data']);
                    $tmp_array = array();
                    for($i = 0; $i < count($data); $i++):
                        $t_val = $data[$i];
                        $tmp_array[] = $t_val;
                        if($t_val == 0) {
                            $pairs_am[$i]["down"]++;
                        }
                        else {
                            $pairs_am[$i]["up"]++;
                        }
                    endfor;
                    $analysis_history[] = $tmp_array;
                }
                while($data = $mysqli->assoc($p_q));
            }

            $result_list = "<tr><td>Результат:</td>";
            for($i = 0; $i < count($pairs_am); $i++):
                $down = $pairs_am[$i]["down"];
                $up = $pairs_am[$i]["up"];
                $sum = $down + $up;
                $down = round(100 * $down / $sum);
                $up = round(100 * $up / $sum);
                $result_list .= "<td><p><i class='fa fa-chevron-circle-up'></i> - {$up}%</p><p><i class='fa fa-chevron-circle-down'></i> - {$down}%</p></td>";
            endfor;
            $result_list .= "</tr>";

            $analysis->change("result", $result_list);

            $analysis->change("list", $list_pairs);

            $analysis_view = "";
            for($i = 0, $t = 9; $i < 8; $i++, $t++):
                $t = $t < 10 ? '0' . $t : $t;
                $time = $t . ":00";
                if(isset($analysis_history[$i])) {
                    $tmp_view = "<tr><td>{$time}</td>";
                    foreach($analysis_history[$i] as $value):
                        $value = $value == "0" ? "down" : "up";
                        $tmp_view .= "<td><i class='fa fa-chevron-circle-{$value}'></i></td>";
                    endforeach;
                    $tmp_view .= "</tr>";
                    $analysis_view .= $tmp_view;
                }
                else {
                    $tmp_view = "<tr><td>{$time}</td>";
                    for($j = 0; $j < $am_pairs; $j++):
                        $tmp_view .= "<td>-</td>";
                    endfor;
                    $tmp_view .= "</tr>";
                    $analysis_view .= $tmp_view;
                }
            endfor;
            $analysis->change("view", $analysis_view);

            $days_signal = new Reader("default");
            $days_signal->view("cabinet/days");
            $pair = "";
            foreach($pairs as $key => $value):
                $smb = $mysqli->query("SELECT * FROM `signals_days` WHERE `date` = '{$date}' AND `symbol` = '{$value}'");
                if($smb->num_rows > 0) {
                    $smb_d = $mysqli->assoc($smb);
                    $bid = $smb_d['bid'];
                    $pos = $smb_d['pos'];
                }
                else {
                    $read = file_get_contents("https://quotes.instaforex.com/api/quotesTick?m=json&q={$key}");
                    $dec = (array)json_decode($read);
                    $dec = (array)$dec[0];
                    $bid = $dec['bid'];
                    $change24 = $dec['change24h'];
                    $pos = $change24 < 0 ? "down" : "up";
                }
                if(date("H:i") < "17:30") {
                    $is_desc = "открывать сделку можно";
                    $is = "yes";
                }
                else {
                    $is_desc = "открывать сделку нельзя";
                    $is = "not";
                }
                $p = new Reader("default");
                $p->view("cabinet/pairs");
                $p->change("symbol", $value);
                $p->change("bid", $bid);
                $p->change("pos", $pos);
                $p->change("is", $is);
                $p->change("is_desc", $is_desc);
                $p->change("symbol", $value);
                $pair .= $p->show();
            endforeach;

            $days_signal->change("date", $date);
            $days_signal->change("uri", URI);

            $this->templateEdit("analysis", $analysis->show());
            if($user['time_vip'] != 'admin') {
                $days_signal->change("analysis", '<a href="#analysis" data-target="#analysis" data-toggle="modal">АНАЛИЗ</a>');
            }
            else {
                $days_signal->change("analysis", '<div class="alert alert-warning">Анализ доступен только VIP пользователям</div>');
            }
            $days_signal->change("pairs", $pair);
            $days_signal = $days_signal->show();
            $data = new Reader("default");
            $data->view("analysis/analysis");
            $data->change("content", $days_signal);
            echo $data->show();
            echo $analysis->show();
        }
        else {
            if($user['timeleft'] <= 0) {
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
        }
    }
}
?>