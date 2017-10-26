<?php
class Stats extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        $date = date("Y-m-d");
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            if($action == "calculate") {
                if(isset($_POST['summ'])) {
                    $signals_amount = $mysqli->query("SELECT `date`, `amount` FROM `signals_amount` WHERE `date` = '{$date}' LIMIT 1");
                    if($signals_amount->num_rows == 1) {
                        $am = $mysqli->assoc($signals_amount);
                        $am = $am['amount'];
                        $summ = $adds->toInteger($_POST['summ']);
                        if($summ != 0) {
                            $deposit = $summ * 2 * 2 * 2 * 2;
                            $profit = $deposit * $summ / 2;
                            echo $profit.";".$deposit;
                        }
                        else {
                            echo "0;0";
                        }
                    }
                    else {
                        echo '0;0';
                    }
                }
                else {
                    echo 'data';
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>