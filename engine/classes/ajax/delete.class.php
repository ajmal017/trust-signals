<?php
class Delete extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $date = date("Y-m-d");
        global $mysqli;
        // DELETE QUOTES
        $mysqli->query("DELETE FROM `quotes` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");
        $mysqli->query("DELETE FROM `quotes_15` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");
        $mysqli->query("DELETE FROM `quotes_30` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");
        echo "<h1>QUOTES</h1>";
        // CLEAR HISTORY ( STATS )
        $mysqli->query("DELETE FROM `signals_stats` WHERE `date` <> '{$date}'");
        echo "<h1>STATS</h1>";
        // CLEAR IS READ MAILS
        $mysqli->query("DELETE FROM `_mails` WHERE `status` = '1'");
        echo "<h1>MAILS</h1>";
        $mysqli->query("DELETE FROM `alerts` WHERE `status` = '0'");
        echo "<h1>NOTIFICATIONS</h1>";
    }
}
?>