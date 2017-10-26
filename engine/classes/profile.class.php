<?php
class Profile extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            $name = $user['name'];
            echo "Профиль пользователя - {$name}";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $user = $adds->getUserData();
        $this->templateEdit("title_content", "Редактирование профиля");

        $disabled_email = "disabled";
        $is_check_email = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'open_email' AND `value` = '1' LIMIT 1");
        if($is_check_email->num_rows == 1) {
            $disabled_email = "";
        }

        $data = new Reader("default");
        $data->view("cabinet/profile");
        $data->change("user_photo", $user['img']);
        $data->change("name", $user['name']);
        $data->change("like", $user['likes']);
        $data->change("dislike", $user['dislikes']);
        $data->change("rank", $user['rank']);
        $data->change("published", $user['amount_signals']);
        $data->change("disabled_email", $disabled_email);
        $data->change("email", $user['email']);
        $data->change("soc", $user['soc_url']);

        $info = new Reader("default");
        $info->view("cabinet/infobox");
        $info->change("text", "Извините, но у Вас отсутствует статус VIP. Вам предоставляется возможность <a href='".URI."/buy/'>приобрести данный пакет</a>");
        $quotes = $info->show();

        if($adds->getLestTimeVIP() > 0) {
            $data->change("status", "VIP");
            $qs = $mysqli->query("SELECT `name`, `translate`, `id` FROM `quotes_list`");
            if($qs->num_rows > 0) {
                $quotes = "";
                $row = $mysqli->assoc($qs);
                do {
                    $checked = "";
                    $info_qt = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `user_id` = '{$user['id']}' AND `translate_name` = '{$row['translate']}' LIMIT 1");
                    if($info_qt->num_rows > 0) {
                        $checked = "checked";
                    }
                    $inp = new Form("default");
                    $quotes .= $inp->input("checkbox", "quotes-list", $row['translate'], "{$row['id']}-checkbox", "", "data-label='{$row['name']}' {$checked}");
                }
                while($row = $mysqli->assoc($qs));
            }
            else {
                $info = new Reader("default");
                $info->view("cabinet/infobox");
                $info->change("text", "Сервис на данный момент не работает с котировками");
                $quotes = $info->show();
            }
        }
        else {
            $data->change("status", "Стандартный");
        }
        $data->change("vip_settings", $quotes);
        echo $data->show();
    }
}
?>