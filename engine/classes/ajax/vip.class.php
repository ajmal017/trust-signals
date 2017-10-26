<?php
class VIP extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            $date = date("Y-m-d");
            if($action == "update-signals" && $user['time_vip'] > 0 && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $quotes_list = array();
                $answer = array();

                $qlist = $mysqli->query("SELECT `translate_name`,`user_id` FROM `users_quotes` WHERE `user_id` = '{$user['id']}'");
                if($qlist->num_rows > 0) {
                    $qbase = $mysqli->assoc($qlist);
                    do {
                        $symbol_name = $mysqli->query("SELECT `name`, `translate` FROM `quotes_list` WHERE `translate` = '{$qbase['translate_name']}' LIMIT 1");
                        if($symbol_name->num_rows == 1) {
                            $sname = $mysqli->assoc($symbol_name);
                            $sname = $sname['name'];
                            $quotes_list[$qbase['translate_name']] = $sname;
                            $answer[$qbase['translate_name']] = array("answer" => "empty", "tmp" => "");
                        }
                    }
                    while($qbase = $mysqli->assoc($qlist));
                }

                foreach($quotes_list as $key => $value):
                    $content = "";
                    $money = 0;
                    $type = 1;
                    $buff = array();
                    $position = "";
                    $power_interest = 0;
                    $date_plus = new DateTime($date);
                    $date_plus->modify("+1 Day");
                    $date_plus = $date_plus->format("Y-m-d");

                    $algs = array(
                        "min15" => array(
                            "sql" => "SELECT * FROM `quotes_15` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' )  ORDER BY `id` DESC LIMIT 10",
                            "minAmount" => 9,
                            "name" => "result_min_15",
                            "addMinutes" => 15
                        ),
                        "min30" => array(
                            "sql" => "SELECT * FROM `quotes_30` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' )  ORDER BY `id` DESC LIMIT 10",
                            "minAmount" => 9,
                            "name" => "result_min_30",
                            "addMinutes" => 30
                        ),
                        "basic" => array(
                            "sql" => "SELECT * FROM `quotes` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' ) ORDER BY `id` DESC",
                            "minAmount" => 8,
                            "addMinutes" => 4
                        )
                    );

                    /* CHECK TYPE OF ALGORITHM */

                    $at = "basic";

                    if(isset($_COOKIE['vip-switch'])) {
                        if($_COOKIE['vip-switch'] == '2') {
                            $at = "min15";
                        }
                        elseif($_COOKIE['vip-switch'] == '3') {
                            $at = "min30";
                        }
                    }

                    $quote = $mysqli->query($algs[$at]["sql"]);
                    if($quote->num_rows > $algs[$at]["minAmount"]) {
                        $q = $mysqli->assoc($quote);
                        do {
                            array_push($buff, $q);
                        }
                        while($q = $mysqli->assoc($quote));

                        if($at == "min15" || $at == "min30") {
                            $vname = explode("/", $value);
                            $vname = strtolower($vname[0].$vname[1]);
                            $closed = $buff[0]['bid'];

                            $min = $buff[0]['bid'];
                            $max = $buff[0]['bid'];

                            for($i = 0; $i < count($buff); $i++) {
                                $min = $min > $buff[$i]['bid'] ? $buff[$i]['bid'] : $min;
                                $max = $max < $buff[$i]['bid'] ? $buff[$i]['bid'] : $max;
                            }

                            $i = 0;

                            $result = ($closed - $min) / ($max - $min) * 100;

                            $resultbd = false;
                            $get_last_result = $mysqli->query("SELECT * FROM `settings` WHERE `title` = '{$algs[$at]['name']}_{$vname}' LIMIT 1");
                            if($get_last_result->num_rows == 1) {
                                $get_last_result = $mysqli->assoc($get_last_result);
                                $resultbd = $adds->toInteger($get_last_result['value']);
                                $mysqli->query("UPDATE `settings` SET `value` = '{$result}', `description` = 'Сигнал на 15-30 минут' WHERE `title` = '{$algs[$at]['name']}_{$vname}'");
                            }
                            else {
                                $mysqli->query("INSERT INTO `settings` (`value`, `title`, `description`) VALUES ('{$result}', '{$algs[$at]['name']}_{$vname}', 'Сигнал на 15-30 минут')");
                            }

                            if($result > 98) {
                                $money = "1-10";
                                $power_interest = rand(72, 89);
                                $position = "down";
                                $buff[$i] = $buff[0];
                            }
                            elseif($result > 76 && $result < 85 && $resultbd < $result) {
                                $money = "1-10";
                                $power_interest = rand(52, 69);
                                $position = "up";
                                $buff[$i] = $buff[0];
                            }
                            elseif($result < 31 && $result > 18 && $resultbd > $result) {
                                $money = "1-10";
                                $power_interest = rand(49, 69);
                                $position = "down";
                                $buff[$i] = $buff[0];
                            }
                            elseif($result < 6) {
                                $money = "1-10";
                                $power_interest = rand(72, 89);
                                $position = "up";
                                $buff[$i] = $buff[0];
                            }
                        }
                        else {
                            for($i = 0; $i < count($buff); $i++):
                                if(isset($buff[$i+3]) && isset($_COOKIE['inv']) && $_COOKIE['inv'] == 'on') {
                                    $signals = array($buff[$i]['bid'], $buff[$i + 1]['bid'], $buff[$i + 2]['bid'], $buff[$i + 3]['bid']);
                                    $type = 0;
                                    if($signals[3] < $signals[2] && $signals[2] < $signals[1] && $signals[1] < $signals[0]) {
                                        $power_interest = 50;
                                        $position = "down";
                                        $money = "2% от депозита";
                                        break;
                                    }
                                    elseif($signals[3] > $signals[2] && $signals[2] > $signals[1] && $signals[1] > $signals[0]) {
                                        $power_interest = 50;
                                        $position = "down";
                                        $money = "2% от депозита";
                                        break;
                                    }
                                    elseif($signals[2] < $signals[1] && $signals[1] < $signals[0]) {
                                        $power_interest = 50;
                                        $position = "up";
                                        $money = "2% от депозита";
                                        break;
                                    }
                                    elseif($signals[2] > $signals[1] && $signals[1] > $signals[0]) {
                                        $power_interest = 50;
                                        $position = "up";
                                        $money = "2% от депозита";
                                        break;
                                    }
                                }
                                elseif(isset($buff[$i+8])) {
                                    $signals = array($buff[$i]['bid'], $buff[$i + 1]['bid'], $buff[$i + 2]['bid'], $buff[$i + 3]['bid'], $buff[$i + 4]['bid'], $buff[$i + 5]['bid'], $buff[$i + 6]['bid'], $buff[$i + 7]['bid'], $buff[$i + 8]['bid']);
                                    if($signals[0] > $signals[1] && $signals[1] > $signals[2]) {
                                        $power_interest = 25;
                                        $position = "down";
                                        $money = "1-3$";
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3]) { $power_interest = 35; $money = "1-3$"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4]) { $power_interest = 45; $money = "3-6$"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5]) { $power_interest = 65; $money = "6-9$"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]) { $power_interest = 75; $money = "9-15$"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]) { $power_interest = 85; $money = "15-20$"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]  && $signals[7] > $signals[8]) { $power_interest = 100; $money = "20-30$";  }
                                        if(isset($_COOKIE['vip-power'])) {
                                            $min = $adds->toInteger(@$_COOKIE['vip-power']);
                                            if($power_interest >= $min) {
                                                break;
                                            }
                                            else {
                                                $position = "";
                                                $power_interest = 0;
                                            }
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                    else {
                                        if($signals[0] < $signals[1] && $signals[1] < $signals[2]) {
                                            $power_interest = 25;
                                            $position = "up";
                                            $money = "1-3$";
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3]) { $power_interest = 35; $money = "1-3$"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4]) { $power_interest = 45; $money = "3-6$"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5]) { $power_interest = 65; $money = "6-9$"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]) { $power_interest = 75; $money = "9-15$"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]) { $power_interest = 85; $money = "15-20$"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]  && $signals[7] < $signals[8]) { $power_interest = 100; $money = "20-30$";  }
                                            if(isset($_COOKIE['vip-power'])) {
                                                $min = $adds->toInteger(@$_COOKIE['vip-power']);
                                                if($power_interest >= $min) {
                                                    break;
                                                }
                                                else {
                                                    $position = "";
                                                    $power_interest = 0;
                                                }
                                            }
                                            else {
                                                break;
                                            }
                                        }
                                    }
                                }
                                else {
                                    break;
                                }
                            endfor;
                        }
                        if(!empty($position)) {
                            $buff = $buff[$i];
                            $date_time = (int)$buff['lasttime'];
                            $time1 = gmdate("Y-m-d H:i:s", $date_time);
                            $time1 = date('Y-m-d H:i:s', strtotime("+".T_STAMP." hour", strtotime($time1)));
                            $addtime = 3;
                            if($type) { $addtime = 4; }
                            if($algs[$at]['addMinutes'] != 4) {
                                $addtime = $algs[$at]['addMinutes'];
                            }
                            $time2 = date('Y-m-d H:i:s', strtotime("+{$addtime} minutes", strtotime($time1)));
                            $signal_data = new Reader("default");
                            $signal_data->view("vip/signals");
                            $signal_data->change("pos", $position);
                            $signal_data->change("bid", $buff['bid']);
                            $signal_data->change("symbol", $buff['symbol']);
                            $signal_data->change("interest", $power_interest);
                            $signal_data->change("status", "В работе");
                            $signal_data->change("status_color", "success");
                            $signal_data->change("id", $buff['id']);
                            $signal_data->change("translate", $key);
                            $signal_data->change("time1", $time1);
                            $signal_data->change("time2", $time2);
                            if($type) { $money .= "$"; }
                            $signal_data->change("money", $money);
                            $signal_data->change("uri", URI);
                            $posname = "";
                            if($position == 'up') {
                                $posname = "выше";
                            }
                            else {
                                $posname = "ниже";
                            }
                            $signal_data->change("pos_name", $posname);

                            $answer[$key]['tmp'] = $signal_data->show();
                            $answer[$key]['answer'] = "success";
                        }
                        else {
                            $answer[$key]['answer'] = "empty";
                            $inf = new Reader("default");
                            $inf->view("cabinet/infobox");
                            $inf->change("text", "В данный момент сигналов по валютной паре <span>\"{$value}\"</span> в работе нет, ожидайте");
                            $answer[$key]['tmp'] = $inf->show();
                        }
                    }
                    else {
                        $answer[$key]['answer'] = "empty";
                        $inf = new Reader("default");
                        $inf->view("cabinet/infobox");
                        $inf->change("text", "В данный момент сигналов по валютной паре <span>\"{$value}\"</span> в работе нет, ожидайте");
                        $answer[$key]['tmp'] = $inf->show();
                    }
                endforeach;
                echo json_encode($answer);
            }
            elseif($action == 'get-news') {
                $news = $mysqli->query("SELECT * FROM `economic_news` ORDER BY `date` DESC");
                if($news->num_rows > 0) {
                    $nb = new Reader("default");
                    $nb->view("vip/news");
                    $nb->change("pos", 0);
                    $nb->change("id", 0);
                    $nb->change("text", "В ближайшее время новостей не будет");
                    $news_box = $nb->show();

                    $news_a = $mysqli->assoc($news);
                    do {
                        $timeleft = round(($news_a['date'] - strtotime("now")) / 60);
                        if($timeleft >= 1 && $timeleft <= 15) {
                            $news_a['date'] = date("Y-m-d H:i:s", $news_a['date']);
                            $nb = new Reader("default");
                            $nb->view("vip/news");
                            $nb->change("pos", 1);
                            $nb->change("id", $news_a['id']);
                            $nb->change("text", "Внимание!!! Новость выйдет через <span>{$timeleft}</span> минут. Полное время выхода <span>{$news_a['date']}</span>");
                            $news_box = $nb->show();
                            break;
                        }
                    }
                    while($news_a = $mysqli->assoc($news));
                }
                else {
                    $nb = new Reader("default");
                    $nb->view("vip/news");
                    $nb->change("pos", 0);
                    $nb->change("id", 0);
                    $nb->change("text", "В ближайшее время новостей не будет");
                    $news_box = $nb->show();
                }
                echo $news_box;
            }
            elseif($action == 'change-time' && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $res = array("answer" => "", "text" => "");
                $time = $adds->toInteger($user['time_vip']);
                if($time - 1 > 0) {
                    $res['answer'] = 'normal';
                    $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` - 1 WHERE `id` = '{$user['id']}'");
                    $res['text'] = $adds->timeleft($time - 1);
                }
                else {
                    $res['answer'] = 'over';
                    $mysqli->query("UPDATE `users` SET `time_vip` = '0' WHERE `id` = '{$user['id']}'");
                    $lock = new Reader("default");
                    $lock->view("cabinet/lock");
                    $lock->change("uri", URI);
                    $res['text'] = $lock->show();
                }
                echo json_encode($res);
            }
        }
        else {
            echo "auth";
        }
    }
}
?>