<?php
class Notification extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            $name = $user['name'];
            echo "Оповещения - {$name}";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Мои оповещения");
        $user = $adds->getUserData();

        $limit = 10;

        $messages = "";
        $mysqli->query("UPDATE `alerts` SET `status` = '0' WHERE `status` = '1' AND `user_id` = '{$user['id']}'");
        $get = $mysqli->query("SELECT * FROM `alerts` WHERE `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$limit}");
        $am = $mysqli->query("SELECT `user_id`  FROM `alerts` WHERE `user_id` = '{$user['id']}'")->num_rows;
        if($get->num_rows > 0) {
            $mess = $mysqli->assoc($get);
            do {
                $data = new Reader("default");
                $data->view("mails/notification");
                $data->change("date", $mess['date']);
                $data->change("id", $mess['id']);
                $data->change("message", $mess['text']);
                $data->change("pos", $mess['icon']);
                $messages .= $data->show();
            }
            while($mess = $mysqli->assoc($get));
        }
        else {
            $data = new Reader("default");
            $data->view("cabinet/infobox");
            $data->change("text", "В данный момент у Вас нет ни одного оповещения, Вы можете перейти в <a href='".URI."/cabinet/'>базовый кабинет</a>");
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