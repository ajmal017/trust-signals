<?php

class Elly extends Core {
    public function getTitle() {
        echo "Элли :)";
    }
    public function getContent() {
        $adds = new Additions();
        if($adds->isAuth()) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $this->templateEdit("title_content", "Элли :)");
            $user = $adds->getUserData();
            $data = new Reader("default");
            $data->view("elly/wrap");
            $elly_val = 0;
            $elly = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'elly' LIMIT 1");
            if($elly->num_rows == 1) {
                $elly = $mysqli->assoc($elly);
                $elly_val = $elly['value'];
            }
            if( ( ($elly_val == 0 && $user['time_vip'] > 0) || ($elly_val == 1 && $user['time_vip'] > 33120) ) && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $signals = array(
                    "eurusd" => "EUR/USD",
                    "gbpusd" => "GBP/USD",
                    "gbpjpy" => "GBP/JPY"
                );

                $list_s = "";

                $algs = array(
                    "min15" => array(
                        "type" => "M15",
                        "mins" => 9000,
                        "tp" => 15
                    ),
                    "min30" => array(
                        "type" => "M30",
                        "mins" => 18000,
                        "tp" => 30
                    ),
                    "basic" => array(
                        "type" => "M1",
                        "mins" => 600,
                        "tp" => 1
                    )
                );
                /* CHECK TYPE OF ALGORITHM */
                $at = "basic";
                if(isset($_COOKIE['elly-switch'])) {
                    if($_COOKIE['elly-switch'] == '2') {
                        $at = "min15";
                    }
                    elseif($_COOKIE['elly-switch'] == '3') {
                        $at = "min30";
                    }
                }

                foreach($signals as $key => $value):
                    $error = "";
                    $res_box = "";
                    $t = date("m.d.Y | H:i");
                    $simbol = $value;
                    $time = time() + 10700; //10680
                    $timedown = $time - $algs[$at]['mins']; /* Настройка времени прошлого 10 свечей назад */
                    $params = array(
                        'chartRequest' => array(
                            'From' => $timedown,
                            'To' => $time,
                            'Symbol' => strtoupper($key),
                            'Type' => $algs[$at]['type'] /*ТФ свечи варианты  MN, W1, D1, H4, H1, M30, M15, M5, and M1 */
                        )
                    );
                    $client = new SoapClient('http://client-api.instaforex.com/soapservices/charts.svc?wsdl');
                    $test = (array)$client->GetCharts($params);
                    $low0 = $test['GetChartsResult']->Candle[0]->Low;
                    $low1 = $test['GetChartsResult']->Candle[1]->Low;
                    $low2 = $test['GetChartsResult']->Candle[2]->Low;
                    $low3 = $test['GetChartsResult']->Candle[3]->Low;
                    $low4 = $test['GetChartsResult']->Candle[4]->Low;
                    $low5 = $test['GetChartsResult']->Candle[5]->Low;
                    $low6 = $test['GetChartsResult']->Candle[6]->Low;
                    $low7 = $test['GetChartsResult']->Candle[7]->Low;
                    $low8 = $test['GetChartsResult']->Candle[8]->Low;
                    $low9 = $test['GetChartsResult']->Candle[9]->Low;

                    $High0 = $test['GetChartsResult']->Candle[0]->High;
                    $High1 = $test['GetChartsResult']->Candle[1]->High;
                    $High2 = $test['GetChartsResult']->Candle[2]->High;
                    $High3 = $test['GetChartsResult']->Candle[3]->High;
                    $High4 = $test['GetChartsResult']->Candle[4]->High;
                    $High5 = $test['GetChartsResult']->Candle[5]->High;
                    $High6 = $test['GetChartsResult']->Candle[6]->High;
                    $High7 = $test['GetChartsResult']->Candle[7]->High;
                    $High8 = $test['GetChartsResult']->Candle[8]->High;
                    $High9 = $test['GetChartsResult']->Candle[9]->High;
                    $closed = $test['GetChartsResult']->Candle[9]->Close;
                    $closed0 = $test['GetChartsResult']->Candle[0]->Close;
                    $date = $test['GetChartsResult']->Candle[9]->Timestamp;
                    $date0 = $test['GetChartsResult']->Candle[0]->Timestamp;
                    $min = min($low0, $low1, $low2, $low3, $low4, $low5, $low6, $low7, $low8, $low9);
                    $max = max($High0, $High1, $High2, $High3, $High4, $High5, $High6, $High7, $High8, $High9);

                    $sql = "SELECT `result`, `id` FROM `elly` WHERE `symbol` = '{$value}' ORDER BY `id` DESC LIMIT 1; ";
                    $result = $mysqli->query($sql);

                    $listRes = array();
                    $reserve = $mysqli->query("SELECT `bid`, `id` FROM `quotes` WHERE `symbol` = '{$value}' ORDER BY `id` DESC LIMIT 10");
                    if($reserve->num_rows == 10) {
                        while($listRes[] = $mysqli->assoc($reserve)) {}
                    }

                    if(empty($High0)) {
                        $High0 = 0;
                    }
                    if(empty($High1)) {
                        $High1 = 0;
                    }
                    if(empty($High2)) {
                        $High2 = 0;
                    }
                    if(empty($High3)) {
                        $High3 = 0;
                    }
                    if(empty($High4)) {
                        $High4 = 0;
                    }
                    if(empty($High5)) {
                        $High5 = 0;
                    }
                    if(empty($High6)) {
                        $High6 = 0;
                    }
                    if(empty($High7)) {
                        $High7 = 0;
                    }
                    if(empty($High8)) {
                        $High8 = 0;
                    }
                    if(empty($High9)) {
                        $High9 = 0;
                    }
                    if(empty($closed)) {
                        $closed = 0;
                    }

                    if (!$result) {
                        $error = "Could not successfully run query ($sql) from DB";
                    }

                    $resultbd = "";

                    if ($result->num_rows > 0) {
                        $row = $mysqli->assoc($result);
                        $resultbd = $row["result"];
                    }
                    $ressult = ($closed - $min) / ($max - $min) * 100;

                    $ostalos = "";
                    $timev = "";
                    $color = "yellow";
                    $pos = "";

                    if(empty($closed)) {
                        unset($ressult);
                        $napravlenie = "<i class='fa fa-refresh fa-spin'></i>";
                        $timev = "Ожидаем выход сигнала: ";
                        $ostalos = "";
                        $textbotom = "нет данных";
                        $down = 0; $up = 0;
                    }
                    elseif($ressult > 98) {
                        $textbotom = "Сигнал расчитан от 1 до 3 мин.";
                        $napravlenie = "<i class='fa fa-arrow-down red'></i>";
                        $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек.";
                        $timev = "Время выхода сигнала:";
                        $color ="red";
                        $pos = "down";
                        $down = rand(81, 89); $up = 100-$down;
                    }
                    elseif($ressult > 76 && $ressult < 85 && $resultbd < $ressult) {
                        $textbotom= "Сигнал расчитан от 1 до 3 мин.";
                        $napravlenie = "<i class='fa fa-arrow-up green'></i>";
                        $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек.";
                        $timev = "Время выхода сигнала:";
                        $color ="green";
                        $pos = "up";
                        $up = rand(51, 59); $down = 100-$up;
                    }
                    elseif($ressult < 31 && $ressult > 18 && $resultbd > $ressult) {
                        $textbotom= "Сигнал расчитан от 1 до 3 мин.";
                        $napravlenie = "<i class='fa fa-arrow-down red'></i>";
                        $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек.";
                        $timev = "Время выхода сигнала:";
                        $color ="red";
                        $pos = "down";
                        $down = rand(51, 62); $up = 100-$down;
                    }
                    elseif($ressult < 4) {
                        $textbotom= "Сигнал расчитан от 1 до 3 мин.";
                        $napravlenie = "<i class='fa fa-arrow-up green'></i>";
                        $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек.";
                        $timev = "Время выхода сигнала:";
                        $color ="green";
                        $pos = "up";
                        $up = rand(71, 79); $down = 100-$up;
                    }
                    else {
                        $napravlenie = "<i class='fa fa-refresh fa-spin'></i>";
                        $timev = "Ожидаем выход сигнала:";
                        $down = 0; $up = 0;
                    }

                    if($down > 0 || $up > 0) {
                        $mysqli->query("INSERT INTO `elly` (`result`, `symbol`) VALUES ('{$ressult}', '{$value}')");
                    }

                    if($error) {
                        $data->change("signal", $error);
                    }
                    else {

                        if($closed == 0 || empty($closed)) {
                            $closed = "0";
                        }

                        $res_box = new Reader("default");
                        $res_box->view("elly/signal_rec");
                        $res_box->change("symbol", $value);
                        $res_box->change("lasttime", $ostalos);
                        $res_box->change("time_1", $timev);
                        $res_box->change("time_2", $t);
                        $res_box->change("pos", $napravlenie);
                        $res_box->change("closed", $closed);
                        $res_box->change("description", $textbotom);
                        $res_box->change("color", $color);
                        $res_box->change("closed", $closed);
                        $res_box->change("integers", "{$High0}, {$High1}, {$High2}, {$High3}, {$High4}, {$High5}, {$High6}, {$High7}, {$High8}, {$High9}");
                        $data->change("signal", $res_box->show());

                        $ind = new Reader("default");
                        $ind->view("elly/indecator");
                        $ind->change("up", $down);
                        $ind->change("down", $up);
                        $data->change("indicator", $ind->show());

                        $mini = new Reader("default");
                        $mini->view("elly/mini_rec");
                        $mini->change("pos_box", $napravlenie);
                        $mini->change("pos", $pos);
                        $mini->change("lasttime", $ostalos);
                        $mini->change("color", $color);
                        $mini->change("time1", $timev);
                        $mini->change("time2", $t);
                        $mini->change("integers", "{$High0}, {$High1}, {$High2}, {$High3}, {$High4}, {$High5}, {$High6}, {$High7}, {$High8}, {$High9}");
                        $mini->change("closed", $closed);
                        $mini->change("description", $textbotom);
                        $mini->change("symbol", $value);
                        $mini->change("lower", $key);
                        $mini->change("closed", $closed);
                        $mini->change("down", $down);
                        $mini->change("up", $up);
                        if(empty($textbotom)) {
                            $textbotom = "нет данных" ;
                        }
                        if(empty($closed)) {
                            $closed = 0;
                        }
                        $mini->change("message", $value." | ".$textbotom . " | ". $closed);
                        $list_s .= $mini->show();
                    }
                    $data->change("symbol", $value);
                    $data->change("symbol_lower", $key);
                endforeach;

                $models = new Reader("default");
                $models->view("elly/models");
                $data->change("models", $models->show());
                $data->change("signals_list", $list_s);
                $hist = $mysqli->query("SELECT `pos`, `result`, `bid`, `id`, `symbol`, `time` FROM `history_elly` ORDER BY `id` DESC LIMIT 10");
                if($hist->num_rows > 0 && $user['group'] == 'admin') {
                    $h_box = new Reader("default");
                    $h_box->view("elly/stats");
                    $hist_list = "";
                    $r_hist = $mysqli->assoc($hist);
                    do {
                        $b = new Reader("default");
                        $b->view("elly/stats_rec");
                        $b->change("symbol", $r_hist['symbol']);
                        $b->change("bid", $r_hist['bid']);
                        $b->change("time", $r_hist['time']);
                        if($r_hist['result'] == 1) {
                            $b->change("if", 'LOSE');
                            $b->change("color_res", 'red');
                        }
                        elseif($r_hist['result'] == 0) {
                            $b->change("if", '-');
                            $b->change("color_res", 'gray');
                        }
                        else {
                            $b->change("if", 'WIN');
                            $b->change("color_res", 'green');
                        }

                        if($r_hist['pos'] == 1) {
                            $b->change("pos", 'up');
                            $b->change("color_pos", 'green');
                        }
                        else {
                            $b->change("pos", 'down');
                            $b->change("color_pos", 'red');
                        }
                        $hist_list .= $b->show();
                    }
                    while($r_hist = $mysqli->assoc($hist));
                    $h_box->change("stats_list", $hist_list);
                    $data->change("history", $h_box->show());
                }
                $data->change("history", "");
                echo $data->show();
            }
            else {
                if($user['time_vip'] < 33120 && $elly_val == 1) {
                    $lock = new Reader("default");
                    $lock->view("cabinet/lock2");
                    $lock->change("uri", URI);
                    echo $lock->show();
                }
                elseif($user['time_vip'] <= 0) {
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