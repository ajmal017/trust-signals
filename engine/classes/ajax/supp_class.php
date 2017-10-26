<?php
class Supp extends Core {
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
        if($adds->isAuth() && ( $user['group'] == 'admin' || $user['group'] == 'moder') ) {
            if($action == "send-message" && isset($_POST['id']) && isset($_POST['text'])) {
                $text = $adds->siftText($_POST['text']);
                $id = $adds->toInteger($_POST['id']);
                if(!empty($text) && $id != 0) {
                    $mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`) VALUES ('{$id}', '{$text}', '{$date}', '0')");
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            if($action == "posts-message" && isset($_POST['text'])) {
                $text = $adds->siftText($_POST['text']);
                if(!empty($text)) {
                    $users_data = $mysqli->query("SELECT `id`, `name` FROM `users`");
                    if($users_data->num_rows > 0) {
                        $users_d = $mysqli->assoc($users_data);
                        do {
                            $id = $users_d['id'];
                            $name = explode(" ", $users_d['name']);
                            $name = $name[0];
                            $text = "Здравствуйте, {$name}.<br /> {$text}";
                            $mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`) VALUES ('{$id}', '{$text}', '{$date}', '0')");
                        }
                        while($users_d = $mysqli->assoc($users_data));
                    }
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-supp" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `support` WHERE `id` = '{$id}'");
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