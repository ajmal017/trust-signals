<?php
class Insert extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        global $mysqli;
        $type = 1;
        if(isset($_GET['type'])) {
            $type = $_GET['type'] == 2 || $_GET['type'] == 3 ? $_GET['type'] : 1;
        }

        $adds = new Additions();
        $date = date("Y-m-d");
        $isset_day = $mysqli->query("SELECT * FROM `signals_amount` WHERE `date` = '{$date}' LIMIT 1");
        if($isset_day->num_rows == 1) {
            $mysqli->query("UPDATE `signals_amount` SET `amount` = `amount` + 1 WHERE `date` = '{$date}'");
        }
        else {
            $mysqli->query("INSERT INTO `signals_amount` (`date`, `amount`) VALUES ('{$date}', '1')");
        }
        $quotes = $mysqli->query("SELECT `name`, `translate` FROM `quotes_list`");
        if($quotes->num_rows > 0) {
            $quote = $mysqli->assoc($quotes);
            do {
                $symbol = $quote['name'];
                $name = $quote['translate'];
                $read = file_get_contents("https://quotes.instaforex.com/api/quotesTick?m=json&q={$name}");
                $dec = (array)json_decode($read);
                $dec = (array)$dec[0];
                $bid = $dec['bid'];
                $lasttime = $dec['lasttime'];

                // insert signal
                $base_name = "quotes";
                if($type == 2) { $base_name = "quotes_15"; } elseif($type == 3) { $base_name = "quotes_30"; }
                $check = $mysqli->query("INSERT INTO `{$base_name}` (`symbol`, `bid`, `lasttime`) VALUES ('{$symbol}', '{$bid}', '{$lasttime}')");
                if(!$check) { echo "Fail: {$symbol}"; continue; }
                // save to history
                if($type == 2 || $type == 3) {
                    continue;
                }
                if($name != 'eurusd' && $name != 'gbpusd' && $name != 'gbpjpy') {
                    continue;
                }
                else {
                    $date =  gmdate("Y-m-d", $adds->toInteger($lasttime));
                    $time =  gmdate("H:i", $adds->toInteger($lasttime));
                    $lfromhist = $mysqli->query("SELECT * FROM `signals_stats` WHERE `symbol` = '{$symbol}' ORDER BY `id` DESC LIMIT 2");
                    if($lfromhist->num_rows >= 1) {
                        $shist = $mysqli->assoc($lfromhist); // new
                        if($lfromhist->num_rows == 1 && $shist['stop'] == '0' && $shist['bid2'] == '0') {
                            $pos = $shist['torb'];
                            if($bid > $shist['bid1']) { $pos = 1; } else { $pos = $pos; }
                            $mysqli->query("UPDATE `signals_stats` SET `bid2` = '{$bid}', `torb` = '{$pos}' WHERE `id` = '{$shist['id']}'");
                        }
                        else {
                            $lbid = 1;
                            if($shist['bid2'] == '0') { $lbid = $lbid; } else { $lbid = 2; }
                            if($shist['bid3'] == '0') { $lbid = $lbid; } else { $lbid = 3; }
                            if($shist['bid4'] == '0') { $lbid = $lbid; } else { $lbid = 4; }

                            if($lbid == 4) {
                                $pos = 0;
                                if($bid > $shist['bid4']) { $pos = 1; }
                                if($bid == $shist['bid4']) { $pos = $shist['torb']; }

                                $mysqli->query("UPDATE `signals_stats` SET `stop` = '4' WHERE `id` = '{$shist['id']}'");
                                $mysqli->query("INSERT INTO `signals_stats`
                                            (`symbol`, `bid1`, `bid2`, `bid3`, `bid4`, `stop`, `torb`, `date`, `time`)
                                        VALUES
                                            ('{$symbol}', '{$bid}', '0', '0', '0', '0', '{$pos}', '{$date}', '{$time}')");
                            }
                            else {
                                $pos = 0;
                                if($bid > $shist['bid'.$lbid]) { $pos = 1; }
                                if($bid == $shist['bid'.$lbid]) { $pos = $shist['torb']; }

                                if($pos == $shist['torb']) {
                                    $new = $lbid + 1;
                                    $mysqli->query("UPDATE `signals_stats` SET `bid{$new}` = '{$bid}' WHERE `id` = '{$shist['id']}'");
                                }
                                else {
                                    $mysqli->query("UPDATE `signals_stats` SET `stop` = '{$lbid}' WHERE `id` = '{$shist['id']}'");
                                    $mysqli->query("INSERT INTO `signals_stats`
                                            (`symbol`, `bid1`, `bid2`, `bid3`, `bid4`, `stop`, `torb`, `date`, `time`)
                                        VALUES
                                            ('{$symbol}', '{$bid}', '0', '0', '0', '0', '{$pos}', '{$date}', '{$time}')");
                                }
                            }
                        }
                    }
                    else {
                        $mysqli->query("INSERT INTO `signals_stats`
                                            (`symbol`, `bid1`, `bid2`, `bid3`, `bid4`, `stop`, `torb`, `date`, `time`)
                                        VALUES
                                            ('{$symbol}', '{$bid}', '0', '0', '0', '0', '0', '{$date}', '{$time}')");
                    }
                }
            }
            while($quote = $mysqli->assoc($quotes));
        }
    }
}
?>