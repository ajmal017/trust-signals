<?php
class Bauth extends Core {
    public function getTitle() {
        echo "Переадресация...";
    }
    public function getContent() {
        global $mysqli;
        $date = date("Y-m-d");
        $this->changeLauncher("clean");
        $adds = new Additions();
        if(isset($_GET['email']) && isset($_GET['password'])) {
            $email = $adds->siftText($_GET['email']);
            $password = $adds->siftText($_GET['password']);
            $auth = $mysqli->query("SELECT `email`, `password`, `id`, `lasttime` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
            if($auth->num_rows == 1) {
                $data = $mysqli->assoc($auth);
                $_SESSION['user'] = $data['id'];
                setcookie("user", $data['id']);
                if($adds->toInteger($data['lasttime']) > 0) {
                    $mysqli->query("UPDATE `users` SET `lasttime_15` = '30', `lasttime_30` = '30' WHERE `id` = '{$data['id']}'");
                }
                echo "<meta http-equiv='Refresh' content='0; URL=".URI."/buy_mobile/'>Если перенаправление не произошло, нажмите <a href='".URI."/buy/'>сюда</a>";
                redirect(URI . "/buy_mobile/");
            }
            else {
                echo 'Ошибка аутентификации';
            }
        }
        else {
            echo 'Ошибка аутентификации';
        }
    }
}
?>