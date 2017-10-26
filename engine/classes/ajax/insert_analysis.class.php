<?php
class Insert_Analysis extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        global $mysqli;
        global $pairs;
        $json = array();
        $date = date("Y-m-d");
        var_dump($pairs);
        foreach($pairs as $key => $value):
            $read = file_get_contents("https://quotes.instaforex.com/api/quotesTick?m=json&q={$key}");
            $dec = (array)json_decode($read);
            $dec = (array)$dec[0];
            $bid = $dec['bid'];
            $change24 = $dec['change24h'];
            $symbol = $value;
            $pos = $change24 < 0 ? "0" : "1";
            $pos2 = $change24 < 0 ? "down" : "up";
            $json[] = $pos;
            if($mysqli->query("SELECT `symbol` FROM `signals_days` WHERE `symbol` = '{$value}'")->num_rows == 0) {
                $mysqli->query("INSERT INTO `signals_days` 
                                    (`symbol`, `date`, `pos`, `bid`)
                                VALUES
                                    ('{$symbol}', '{$date}', '{$pos2}', '{$bid}')");
            }
            else {
                $mysqli->query("UPDATE `signals_days`
                                SET 
                                    `symbol` = '{$symbol}', `date`= '{$date}', `pos` = '{$pos2}', `bid`= '{$bid}'
                                WHERE
                                    `symbol` = '{$value}'");
            }
        endforeach;
        $list = "[". implode(",", $json) ."]";
        echo "<h1>{$list}</h1>";
        $mysqli->query("INSERT INTO `analysis` (`data`, `date`) VALUES ('{$list}', '{$date}')");
    }
}
?>