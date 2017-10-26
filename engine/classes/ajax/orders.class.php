<?php
class Orders extends Core {
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
        $user = $adds->getUserData();
        if($adds->isAuth() && $user['group'] == 'admin') {
            if($action == "confirm-order" && isset($_POST['id']) && isset($_POST['package'])) {
                $pack_id  = $adds->toInteger($_POST['package']);
                $id  = $adds->toInteger($_POST['id']);
                $exist_pack = $mysqli->query("SELECT `type`, `time`, `id` FROM `packages` WHERE `id` = '{$pack_id}' LIMIT 1");
                if($exist_pack->num_rows == 1) {
                    $exist_order = $mysqli->query("SELECT `user_id`, `id` FROM `orders` WHERE `id` = '{$id}' LIMIT 1");
                    if($exist_order->num_rows == 1) {
                        $user_id = $mysqli->assoc($exist_order);
                        $user_id = $user_id['user_id'];
                        $package = $mysqli->assoc($exist_pack);
                        $time = $package['time'];
                        $type = $package['type'];
                        $mysqli->query("UPDATE `orders` SET `status` = '1' WHERE `id` = '{$id}'");
                        if($type == 'vip') {
                            $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` + {$time} WHERE `id` = '{$user_id}'");
                            $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + {$time} WHERE `id` = '{$user_id}'");
                        }
                        else {
                            $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + {$time} WHERE `id` = '{$user_id}'");
                        }
                        echo 'success';
                    }
                    else {
                        echo 'error';
                    }
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "remove-order" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `orders` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>