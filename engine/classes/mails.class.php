<?php
class Mails extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            $name = $user['name'];
            echo "Сообщения - {$name}";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Мои сообщения");
        $user = $adds->getUserData();

        $limit = 10;

        $messages = "";
        $get = $mysqli->query("SELECT * FROM `_mails` WHERE `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$limit}");
        $am = $mysqli->query("SELECT `user_id`  FROM `_mails` WHERE `user_id` = '{$user['id']}'")->num_rows;
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
        }
        else {
            $data = new Reader("default");
            $data->view("cabinet/infobox");
            $data->change("text", "В данный момент у Вас нет ни одного сообщения, Вы можете перейти в <a href='".URI."/cabinet/'>базовый кабинет</a>");
            $messages = $data->show();
        }

        $wrap = new Reader("default");
        $wrap->view("mails/wrapper");
        $wrap->change("content", $messages);
        echo $wrap->show();

        if($am > $limit) {
            $wrap = new Reader("default");
            $wrap->view("mails/loadmore");
            echo $wrap->show();
        }
    }
}
?>