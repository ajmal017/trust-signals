<?php
class Cabinet extends Core {
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
            if($action == "update-signals" && $user['timeleft'] > 0 && $user['confirm'] == 1 && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $quotes_list = array("eurusd" => "EUR/USD",
                                     "gbpusd" => "GBP/USD",
                                     "gbpjpy" => "GBP/JPY");
                $answer = array("eurusd" => array("answer" => "empty", "tmp" => "", "dbox" => ""),
                                "gbpusd" => array("answer" => "empty", "tmp" => "", "dbox" => ""),
                                "gbpjpy" => array("answer" => "empty", "tmp" => "", "dbox" => ""));
                foreach($quotes_list as $key => $value):
                    /* CHECK TYPE OF ALGORITHM */
                    $at = "basic";
                    if(isset($_COOKIE['cabinet-switch'])) {
                        if($_COOKIE['cabinet-switch'] == '2') {
                            $at = "min15";
                        }
                        elseif($_COOKIE['cabinet-switch'] == '3') {
                            $at = "min30";
                        }
                    }

                    $content = "";
                    $money = 0;
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
                            "addMinutes" => 15,
                            "base" => "quotes_15",
                            "var" => "lasttime_15"
                        ),
                        "min30" => array(
                            "sql" => "SELECT * FROM `quotes_30` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' )  ORDER BY `id` DESC LIMIT 10",
                            "minAmount" => 9,
                            "name" => "result_min_30",
                            "addMinutes" => 30,
                            "base" => "quotes_30",
                            "var" => "lasttime_15"
                        ),
                        "basic" => array(
                            "sql" => "SELECT * FROM `quotes` WHERE `symbol` = '{$value}' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' ) ORDER BY `id` DESC",
                            "minAmount" => 8,
                            "addMinutes" => 4
                        )
                    );

                    $quote = $mysqli->query($algs[$at]["sql"]);
                    if($quote->num_rows > $algs[$at]["minAmount"]) {
                        $q = $mysqli->assoc($quote);
                        do {
                            array_push($buff, $q);
                        }
                        while($q = $mysqli->assoc($quote));

                        $isValidate = true;

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
                                if(isset($buff[$i+8])) {
                                    $signals = array($buff[$i]['bid'], $buff[$i + 1]['bid'], $buff[$i + 2]['bid'], $buff[$i + 3]['bid'], $buff[$i + 4]['bid'], $buff[$i + 5]['bid'], $buff[$i + 6]['bid'], $buff[$i + 7]['bid'], $buff[$i + 8]['bid']);
                                    if($signals[0] > $signals[1] && $signals[1] > $signals[2]) {
                                        $power_interest = 25;
                                        $position = "down";
                                        $money = "1-3";
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3]) { $power_interest = 35; $money = "1-3"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4]) { $power_interest = 45; $money = "3-6"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5]) { $power_interest = 65; $money = "6-9"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]) { $power_interest = 75; $money = "9-15"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]) { $power_interest = 85; $money = "15-20"; }
                                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]  && $signals[7] > $signals[8]) { $power_interest = 100; $money = "20-30";  }
                                        break;
                                    }
                                    else {
                                        if($signals[0] < $signals[1] && $signals[1] < $signals[2]) {
                                            $power_interest = 25;
                                            $position = "up";
                                            $money = "1-3";
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3]) { $power_interest = 35; $money = "1-3"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4]) { $power_interest = 45; $money = "3-6"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5]) { $power_interest = 65; $money = "6-9"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]) { $power_interest = 75; $money = "9-15"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]) { $power_interest = 85; $money = "15-20"; }
                                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]  && $signals[7] < $signals[8]) { $power_interest = 100; $money = "20-30";  }
                                            break;
                                        }
                                    }
                                }
                                else {
                                    break;
                                }
                            endfor;

                            $history_last = $mysqli->query("SELECT * FROM `signals_stats` WHERE `symbol` = '{$value}' AND `stop` <> '0' ORDER BY `id` DESC LIMIT 1");
                            if($history_last->num_rows == 1) {
                                $history_last = $mysqli->assoc($history_last);
                                $history_last = "{$history_last['date']} {$history_last['time']}";
                                $quote_last = (int)$buff[$i]['lasttime'];
                                $quote_last = gmdate("Y-m-d H:i:s", $quote_last);
                                if($quote_last < $history_last) {
                                    $isValidate = false;
                                }
                            }
                        }

                        if(!empty($position) && $isValidate) {
                            $buff = $buff[$i];
                            $date_time = (int)$buff['lasttime'];
                            $time1 = gmdate("Y-m-d H:i:s", $date_time);
                            $time1 = date('Y-m-d H:i:s', strtotime("+".T_STAMP." hour", strtotime($time1)));
                            $time2 = date('Y-m-d H:i:s', strtotime("+{$algs[$at]['addMinutes']} minutes", strtotime($time1)));
                            $signal_data = new Reader("default");
                            $signal_data->view("cabinet/signals");
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
                            $answer[$key]['dbox'] = array(
                                "id" => $buff['id'],
                                "pos" => $position,
                                "bid" => $buff['bid'],
                                "interest" => $power_interest,
                                "time1" => $time1,
                                "time2" => $time2,
                                "money" => $money,
                                "posname" => $posname
                            );
                        }
                        else {
                            $answer[$key]['answer'] = "empty";
                            $inf = new Reader("default");
                            $inf->view("cabinet/infobox");
                            $inf->change("text", "В данный момент сигналов в работе нет, ожидайте");
                            $answer[$key]['tmp'] = $inf->show();
                        }
                    }
                    else {
                        $answer[$key]['answer'] = "empty";
                        $inf = new Reader("default");
                        $inf->view("cabinet/infobox");
                        $inf->change("text", "В данный момент сигналов в работе нет, ожидайте");
                        $answer[$key]['tmp'] = $inf->show();
                    }
                endforeach;
                if(( $at == "min15" && $user['lasttime_15'] > 0 ) || ( $at == "min30" && $user['lasttime_30'] > 0 ) || $at == "basic") {
                    echo json_encode($answer);
                }
                else {
                    echo "signalsisover";
                }
            }
            elseif($action == 'create-notification' && $user['confirm'] == 1) {
                if(isset($_POST['text']) && isset($_POST['icon'])) {
                    $text = $adds->siftText($_POST['text']);
                    $icon = $adds->siftText($_POST['icon']);
                    if($icon == 'up' || $icon == 'down') {
                        $mysqli->query("INSERT INTO `alerts` (`user_id`, `icon`, `text`, `date`, `status`) VALUES ('{$user['id']}', '{$icon}', '{$text}', '{$date}', '1')");
                        echo 'success';
                    }
                    else {
                        echo 'data';
                    }
                }
                else {
                    echo 'data';
                }
            }
            elseif($action == 'change-amount' && $user['confirm'] == 1 && date("l") != "Saturday" &&  date("l") != "Sunday" && isset($_POST['type'])) {
                $type = $adds->toInteger($_POST['type']);
                $var = "lasttime_15";
                if($type == 2) {
                    $var = $var;
                }
                elseif($type == 3) {
                    $var = "lasttime_30";
                }
                if($adds->toInteger($user[$var]) > 0) {
                    $mysqli->query("UPDATE `users` SET `{$var}` = `{$var}` - 1 WHERE `id` = '{$user['id']}'");
                }
            }
            elseif($action == 'change-time' && $user['confirm'] == 1 && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $res = array("answer" => "", "text" => "");
                $time = $adds->toInteger($user['timeleft']);
                if($time - 1 > 0) {
                    $res['answer'] = 'normal';
                    $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` - 1 WHERE `id` = '{$user['id']}'");
                    $res['text'] = $adds->timeleft($time - 1);
                }
                else {
                    $res['answer'] = 'over';
                    $mysqli->query("UPDATE `users` SET `timeleft` = '0' WHERE `id` = '{$user['id']}'");
                    $lock = new Reader("default");
                    $lock->view("cabinet/lock");
                    $lock->change("uri", URI);
                    $res['text'] = $lock->show();
                }

                echo json_encode($res);
            }
            elseif($action == 'last-time') {
                $time = time();
                $mysqli->query("UPDATE `users` SET `lasttime` = '{$time}' WHERE `id` = '{$user['id']}'");
            }
        }
        else {
            echo "auth";
        }
    }
}
?>