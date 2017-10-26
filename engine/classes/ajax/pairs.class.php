<?php
class Pairs extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        global $pairs;

        $user = $adds->getUserData();

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

        if(date("l") == "Saturday" ||  date("l") == "Sunday") {
            $lock = new Reader("default");
            $lock->view("cabinet/output2");
            $lock->change("uri", URI);
            $pair = $lock->show();
        }
        echo $pair;

    }
}
?>