<?php
class Key extends Core {
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
            if($action == "key") {
                if(isset($_POST['key'])) {
                    $key = $adds->siftText($_POST['key']);
                    $get = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'key' LIMIT 1");
                    if($get->num_rows == 1) {
                        $ks = $mysqli->assoc($get);
                        if($ks['value'] == $key) {
                            $data = $mysqli->query("SELECT `timeleft`, `id`, `inp_key` FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1");
                            if($data->num_rows == 1) {
                                $usr = $mysqli->assoc($data);
                                if($usr['inp_key'] != $key) {
                                    $amount = 0;
                                    $am = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'quantity_minutes' LIMIT 1");
                                    if($am->num_rows == 1) {
                                        $am = $mysqli->assoc($am);
                                        $amount = $adds->toInteger($am['value']);
                                    }
                                    $mysqli->query("UPDATE `users` SET `inp_key` = '{$key}' WHERE `id` = '{$user['id']}'");
                                    $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + {$amount} WHERE `id` = '{$user['id']}'");
                                    echo $adds->timeleft($amount + $usr['timeleft']);
                                }
                                else {
                                    echo "error";
                                }
                            }
                            else {
                                echo "error";
                            }
                        }
                        else {
                            echo "error";
                        }
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo "error";
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>