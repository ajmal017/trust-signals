<?php
class Demo extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $date = date("Y-m-d");
        $adds = new Additions();
        global $mysqli;
        $temp = array(
            "template" => "",
            "code" => "",
            "bid" => "",
            "time1" => "",
            "time2" => ""
        );

        $lasttime = 0;

        if(isset($_COOKIE['demo-lasttime'])) {
            $lasttime = $adds->toInteger($_COOKIE['demo-lasttime']);
        }

        $money = 0;
        $type = 1;
        $buff = array();
        $position = "";
        $power_interest = 0;
        $date_plus = new DateTime($date);
        $date_plus->modify("+1 Day");
        $date_plus = $date_plus->format("Y-m-d");
        $quote = $mysqli->query("SELECT * FROM `quotes` WHERE `symbol` = 'EUR/USD' AND ( date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date}' OR date_format(from_unixtime(`lasttime`), '%Y-%m-%d') = '{$date_plus}' ) ORDER BY `id` DESC");
        if($quote->num_rows > 8) {
            $q = $mysqli->assoc($quote);
            do {
                array_push($buff, $q);
            }
            while($q = $mysqli->assoc($quote));
            for($i = 0; $i < count($buff); $i++):
                if(isset($buff[$i+8])) {
                    $signals = array($buff[$i]['bid'], $buff[$i + 1]['bid'], $buff[$i + 2]['bid'], $buff[$i + 3]['bid'], $buff[$i + 4]['bid'], $buff[$i + 5]['bid'], $buff[$i + 6]['bid'], $buff[$i + 7]['bid'], $buff[$i + 8]['bid']);
                    if($signals[0] > $signals[1] && $signals[1] > $signals[2]) {
                        $power_interest = 78;
                        $position = "down";
                        $money = "1-3$";
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3]) { $power_interest = 82; $money = "1-3$"; }
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4]) { $power_interest = 85; $money = "3-6$"; }
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5]) { $power_interest = 87; $money = "6-9$"; }
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]) { $power_interest = 89; $money = "9-15$"; }
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]) { $power_interest = 92; $money = "15-20$"; }
                        if($signals[0] > $signals[1] && $signals[1] > $signals[2] && $signals[2] > $signals[3] && $signals[3] > $signals[4] && $signals[4] > $signals[5] && $signals[5] > $signals[6]  && $signals[6] > $signals[7]  && $signals[7] > $signals[8]) { $power_interest = 95; $money = "20-30$";  }
                        break;
                    }
                    else {
                        if($signals[0] < $signals[1] && $signals[1] < $signals[2]) {
                            $power_interest = 78;
                            $position = "up";
                            $money = "1-3$";
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3]) { $power_interest = 82; $money = "1-3$"; }
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4]) { $power_interest = 85; $money = "3-6$"; }
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5]) { $power_interest = 87; $money = "6-9$"; }
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]) { $power_interest = 89; $money = "9-15$"; }
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]) { $power_interest = 92; $money = "15-20$"; }
                            if($signals[0] < $signals[1] && $signals[1] < $signals[2] && $signals[2] < $signals[3] && $signals[3] < $signals[4] && $signals[4] < $signals[5] && $signals[5] < $signals[6]  && $signals[6] < $signals[7]  && $signals[7] < $signals[8]) { $power_interest = 95; $money = "20-30$";  }
                            break;
                        }
                    }
                }
                else {
                    break;
                }
            endfor;
            if(!empty($position)) {
                $buff = $buff[$i];
                $date_time = (int)$buff['lasttime'];
                $time1 = gmdate("Y-m-d H:i:s", $date_time);
                $time1 = date('Y-m-d H:i', strtotime("+0 hour", strtotime($time1)));

                $temp = new Reader("default");
                $temp->view("demo/read");
                $temp->change("time", $time1);
                $temp->change("bid", $buff["bid"]);
                $temp->change("power", $power_interest);
                $temp->change("lasttime", $lasttime);
                $pos = $position == "down" ? "arrow-down" : "arrow-up";
                $color = $position == "down" ? "red" : "green";
                $temp->change("pos", $pos);
                $temp->change("color", $color);
                $temp = $temp->show();
            }
            else {
                $temp = new Reader("default");
                $temp->view("demo/empty");
                $temp->change("lasttime", $lasttime);
                $temp = $temp->show();
            }
        }
        else {
            $temp = new Reader("default");
            $temp->view("demo/empty");
            $temp->change("lasttime", $lasttime);
            $temp = $temp->show();
        }
        if($lasttime > 0) {
            echo $temp;
        }
        else {
            $temp = new Reader("default");
            $temp->view("demo/buy");
            echo $temp->show();
        }
    }
}
?>