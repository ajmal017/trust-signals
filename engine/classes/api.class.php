<?php
class API extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $date = date("Y-m-d");
        global $mysqli;
        $params = explode("/", $_GET['data']);
        if(count($params) > 1) {
            $key = $params[0];
            $action = $params[1];
            $params = array_slice($params, 2);

            $b_key = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'api' LIMIT 1");

            if($b_key->num_rows == 1) {
                $b_key = $mysqli->assoc($b_key);
                $b_key = $b_key['value'];
            }
            else {
                exit("SET OF KEY UNDEFINED");
            }

            if($key == $b_key) {
                if($action == "auth" && isset($params[0]) && isset($params[1])) {
                    $email = $adds->siftText($params[0]);
                    $password = md5($params[1]);
                    $auth = $mysqli->query("SELECT `email`, `password` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
                    if($auth->num_rows == 1) {
                        exit("1");
                    }
                    else {
                        exit("0");
                    }
                }
                elseif($action == "get_type" && isset($params[0]) && isset($params[1])) {
                    $email = $adds->siftText($params[0]);
                    $password = md5($params[1]);
                    $auth = $mysqli->query("SELECT `email`, `password`, `vip_1` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
                    if($auth->num_rows == 1) {
                        $data = $mysqli->assoc($auth);
                        exit($data['vip_1']);
                    }
                    else {
                        exit("0");
                    }
                }
                elseif($action == "time" && isset($params[0]) && isset($params[1])) {
                    $email = $adds->siftText($params[0]);
                    $password = md5($params[1]);
                    $auth = $mysqli->query("SELECT `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
                    if($auth->num_rows == 1) {
                        $data = $mysqli->assoc($auth);
                        exit($data['time_vip']);
                    }
                    else {
                        exit("0");
                    }
                }
                elseif($action == "update" && isset($params[0]) && isset($params[1]) && isset($params[2])) {
                    $email = $adds->siftText($params[0]);
                    $password = md5($params[1]);
                    $splice = $adds->toInteger($params[2]);
                    $auth = $mysqli->query("SELECT `email`, `password`, `time_vip` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
                    if($auth->num_rows == 1) {
                        $data = $mysqli->assoc($auth);
                        $time = $adds->toInteger($data['time_vip']);
                        if($time > $splice) {
                            $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` - {$splice} WHERE `email` = '{$email}' AND `password` = '{$password}'");
                            echo $time - $splice;
                            exit;
                        }
                        else {
                            $mysqli->query("UPDATE `users` SET `time_vip` = 0 WHERE `email` = '{$email}' AND `password` = '{$password}'");
                            exit("0");
                        }
                    }
                    else {
                        exit("0");
                    }
                }
            }
            else {
                echo "API KEY ERROR";
                exit;
            }
        }
        else {
            exit("0");
        }
    }
}
?>