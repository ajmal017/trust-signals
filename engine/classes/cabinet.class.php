<?php
class Cabinet extends Core {
    public function getTitle() {
        echo "Базовый кабинет";
    }
    public function getContent() {
        $adds = new Additions();
        if($adds->isAuth()) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $this->templateEdit("title_content", "Базовый кабинет");
            $user = $adds->getUserData();
            $data = new Reader("default");
            $data->view("cabinet/cabinet");
            if($user['timeleft'] > 0 && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {

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

                /* QUOTES */
                $quotes_list = array("eurusd" => "EUR/USD",
                                     "gbpusd" => "GBP/USD",
                                     "gbpjpy" => "GBP/JPY");
                foreach($quotes_list as $key => $value):
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
                            if($position == 'up') {
                                $signal_data->change("pos_name", "выше");
                            }
                            else {
                                $signal_data->change("pos_name", "ниже");
                            }
                            $content = $signal_data->show();
                        }
                        else {
                            $inf = new Reader("default");
                            $inf->view("cabinet/infobox");
                            $inf->change("text", "В данный момент сигналов в работе нет, ожидайте");
                            $content = $inf->show();
                        }
                    }
                    else {
                        $inf = new Reader("default");
                        $inf->view("cabinet/infobox");
                        $inf->change("text", "В данный момент сигналов в работе нет, ожидайте");
                        $content = $inf->show();
                    }

                    if(( $at == "min15" && $user['lasttime_15'] > 0 ) || ( $at == "min30" && $user['lasttime_30'] > 0 ) || $at == "basic") {
                        $content = $content;
                    }
                    else {
                        $inf = new Reader("default");
                        $inf->view("cabinet/infobox");
                        $inf->change("text", "Ваш лимит сигналов был исчерпан");
                        $content = $inf->show();
                    }

                    $data->change($key, $content);
                    /* SHOW HISTORY */
                    $hbox = "";
                    $history = $mysqli->query("SELECT * FROM `signals_stats` WHERE `symbol` = '{$value}' AND `stop` <> '0' ORDER BY `id` DESC LIMIT 2");
                    if($history->num_rows > 0) {
                        $hbox = "";
                        $h = $mysqli->assoc($history);
                        do {
                            $pi = 25;
                            $rate = '1-3';

                            if($h['stop'] == 2) {
                                $pi = 50;
                                $rate = '3-6';
                            }
                            elseif($h['stop'] == 3) {
                                $pi = 75;
                                $rate = '6-12';
                            }
                            elseif($h['stop'] == 4) {
                                $pi = 100;
                                $rate = '12-20';
                            }
                            $torb = 'up';
                            if($h['torb'] == '0') {
                                $torb = 'down';
                            }

                            $bid = $h['bid'.$h['stop']];

                            $time1 = $h['date']." ".$h['time'];
                            $time2 = date('Y-m-d H:i:s', strtotime("+4 minutes", strtotime($time1)));
                            $signal_data = new Reader("default");
                            $signal_data->view("cabinet/signals");
                            $signal_data->change("pos", $torb);
                            $signal_data->change("bid", $bid);
                            $signal_data->change("symbol", $h['symbol']);
                            $signal_data->change("interest", $pi);
                            $signal_data->change("status", "Отработал");
                            $signal_data->change("status_color", "danger");
                            $signal_data->change("id", $h['id']);
                            $signal_data->change("translate", $key);
                            $signal_data->change("time1", $time1);
                            $signal_data->change("time2", $time2);
                            $signal_data->change("money", $rate);
                            $signal_data->change("uri", URI);
                            if($torb == 'up') {
                                $signal_data->change("pos_name", "выше");
                            }
                            else {
                                $signal_data->change("pos_name", "ниже");
                            }
                            $hbox .= $signal_data->show();
                        }
                        while($h = $mysqli->assoc($history));
                    }
                    $data->change("history-".$key, $hbox);
                endforeach;
                /* USERS SIGNALS */
                $users = "";
                $limit = 6;
                $exists = $mysqli->query("SELECT * FROM `users_signals` ORDER BY `id` DESC LIMIT {$limit}");
                $am = $mysqli->query("SELECT * FROM `users_signals`")->num_rows;
                if($exists->num_rows > 0) {
                    $signal = $mysqli->assoc($exists);
                    do {
                        $name = "Аноним";
                        $img = URI."/engine/templates/default/img/author.jpg";
                        $rank = 0;
                        $usr = $mysqli->query("SELECT `name`, `img`, `rank` FROM `users` WHERE `id` = '{$signal['user_id']}' LIMIT 1");
                        if($usr->num_rows == 1) {
                            $usr = $mysqli->assoc($usr);
                            if(!empty($usr['img'])) {
                                $img = $usr['img'];
                            }
                            $rank = $usr['rank'];
                            $name = $usr['name'];
                        }
                        $pos = 'down';
                        if($signal['torb'] == 1) {
                            $pos = 'up';
                        }
                        $v_box = "";
                        $votes = $signal['like'] + $signal['dislike'];
                        $interest = $signal['like'] * 100 / $votes;
                        $ready_vote = $mysqli->query("SELECT `signal_id`, `user_id`, `point` FROM `users_points` WHERE `signal_id` = '{$signal['id']}' AND `user_id` = '{$user['id']}' LIMIT 1");
                        if($ready_vote->num_rows == 1) {
                            $vi = $mysqli->assoc($ready_vote);
                            $message = "Подтверждение";
                            if($vi['point'] == 0) {
                                $message = "Отрицание";
                            }
                            $vb = new Reader("default");
                            $vb->view("cabinet/ready_votes");
                            $vb->change("message", $message);
                            $vb->change("type", $vi['point']);
                            $v_box = $vb->show();
                        }
                        else {
                            $vb = new Reader("default");
                            $vb->view("cabinet/votes");;
                            $vb->change("amount", $votes);
                            $v_box = $vb->show();
                        }
                        $sg = new Reader("default");
                        $sg->view("cabinet/user");
                        $sg->change("photo", $img);
                        $sg->change("name", $name);
                        $sg->change("rank", $rank);
                        $sg->change("symbol", $signal['symbol']);
                        $sg->change("time_exp", $signal['exp_time']);
                        $sg->change("time", $signal['time']);
                        $sg->change("date", $signal['date']);
                        $sg->change("id", $signal['id']);
                        $sg->change("pos", $pos);
                        $sg->change("interest", $interest);
                        $sg->change("votes", $v_box);
                        $users .= $sg->show();
                    }
                    while($signal = $mysqli->assoc($exists));
                }
                else {
                    $ib = new Reader("default");
                    $ib->view("cabinet/infobox");
                    $ib->change("text", "В данный момент сигналов от пользователей нет, но Вам предоставляется возможность <a  data-toggle='modal' data-target='#apply-user-signal' class='apply-user-signal' href='#'>добавить первый сигнал</a>");
                    $users = $ib->show();
                }
                $data->change("users", $users);
                $loadm = "";
                if($am > $limit) {
                    $wrap = new Reader("default");
                    $wrap->view("mails/loadmore");
                    $loadm =  $wrap->show();
                }
                $data->change("users-load-more", $loadm);
                $symbols = "";
                $qs = $mysqli->query("SELECT `name` FROM `quotes_list`");
                if($qs->num_rows > 0) {
                    $row = $mysqli->assoc($qs);
                    do {
                        $symbols .= "<option>{$row['name']}</option>";
                    }
                    while($row = $mysqli->assoc($qs));
                }
                $data->change("symbols", $symbols);
                $data->change("uri", URI);

                $ip = $_SERVER['REMOTE_ADDR'];
                $lang = tabgeo_country_v4($ip);
                $l_base = $lang;

                if($mysqli->query("SELECT * FROM `windows` WHERE `lang` = 'all' LIMIT 1")->num_rows > 0) {
                    $lang = "ALL";
                }

                if($mysqli->query("SELECT * FROM `windows` WHERE `lang` = 'NOT_RU' LIMIT 1")->num_rows > 0) {
                    if($l_base != "RU") {
                        $lang = "NOT_RU";
                    }
                }

                $w_info = $mysqli->query("SELECT * FROM `windows` WHERE `lang` = '{$lang}' LIMIT 1");
                if($w_info->num_rows == 1) {
                    $w_info = $mysqli->assoc($w_info);
                    $data->change("spam_content", $w_info['text']);
                    $data->change("spam_title", $w_info['title']);
                    $data->change("spam_checker", "ok");
                    $data->change("spam_days", $w_info['time']);
                }
                else {
                    $data->change("spam_checker", "bad");
                    $data->change("spam_days", 0);
                }

                echo $data->show();
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
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>