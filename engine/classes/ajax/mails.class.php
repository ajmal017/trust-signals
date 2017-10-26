<?php
class Mails extends Core {
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
            if($action == "load-mails") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $num = $adds->toInteger($_POST['n']);
                    $get = $mysqli->query("SELECT * FROM `_mails` WHERE `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$num}, 10");
                    if($get->num_rows > 0) {
                        $mess = $mysqli->assoc($get);
                        do {
                            $text = $mess['text'];
                            if(mb_strlen($text) > 100) {
                                $text = mb_substr($text, 0, 90)."...";
                            }
                            $data = new Reader("default");
                            $data->view("mails/mails");
                            $data->change("date", $mess['date']);
                            $data->change("id", $mess['id']);
                            $data->change("message", $text);
                            if(!$mess['status']) {
                                $data->change("color-new", "new-mail");
                            }
                            else {
                                $data->change("color-new", "");
                            }
                            if(!$mess['side']) {
                                $data->change("side", "");
                                $data->change("name", "Администратор");
                                $data->change("photo", URI.'/engine/templates/default/img/admin.jpg');
                            }
                            else {
                                $data->change("side", "col-md-offset-3 float-right");
                                $data->change("name", $user['name']);
                                $data->change("photo", $user['img']);
                            }
                            $messages .= $data->show();
                        }
                        while($mess = $mysqli->assoc($get));
                        echo $messages;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "load-message") {
                if(isset($_POST['id'])) {
                    $id = $adds->toInteger($_POST['id']);
                    $get = $mysqli->query("SELECT * FROM `_mails` WHERE `user_id` = '{$user['id']}' AND `id` = '{$id}' LIMIT 1");
                    if($get->num_rows == 1) {
                        $mess = $mysqli->assoc($get);
                        $mysqli->query("UPDATE `_mails` SET `status` = '1' WHERE `id` = '{$mess['id']}'");
                        $wrap = new Reader("default");
                        $wrap->view("mails/open");
                        $wrap->change("photo", URI.'/engine/templates/default/img/admin.jpg');
                        $wrap->change("message", $mess['text']);
                        $wrap->change("uri", URI);
                        echo $wrap->show();
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == 'update-mails') {
                $am = $mysqli->query("SELECT COUNT(*) AS `count` FROM `_mails` WHERE `user_id` = '{$user['id']}' AND `status` = '0'");
                $amount = $mysqli->assoc($am);
                $amount = $amount['count'];
                echo $amount;
            }
            elseif($action == 'remove-messages') {
                if(isset($_POST['id'])) {
                    $id = $adds->toInteger($_POST['id']);
                    $exist = $mysqli->query("SELECT `id`, `user_id` FROM `_mails` WHERE `id` = '{$id}' AND `user_id` = '{$user['id']}' LIMIT 1");
                    if($exist->num_rows == 1) {
                        if(isset($_POST['remove-all'])) {
                            $mysqli->query("DELETE FROM `_mails` WHERE `user_id` = '{$user['id']}'");
                            $data = new Reader("default");
                            $data->view("cabinet/infobox");
                            $data->change("text", "В данный момент у Вас нет ни одного сообщения, Вы можете перейти в <a href='".URI."/cabinet/'>базовый кабинет</a>");
                            echo $data->show();
                        }
                        else {
                            $mysqli->query("DELETE FROM `_mails` WHERE `id` = '{$id}'");
                            $data = new Reader("default");
                            $data->view("cabinet/infobox");
                            $data->change("text", "В данный момент у Вас нет ни одного сообщения, Вы можете перейти в <a href='".URI."/cabinet/'>базовый кабинет</a>");
                            echo $data->show();
                        }
                    }
                    else {
                        echo 'error';
                    }
                }
                else {
                    echo 'error';
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>