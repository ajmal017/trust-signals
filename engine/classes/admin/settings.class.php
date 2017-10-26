<?php
class Settings extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Настройки - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Настройки");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
            $wrap = new Reader("default");
            $wrap->view("admin/settings");
            $key_val = "Ошибка при попытке достать ключ, сисемная ошибка";
            $minutes_val = "Ошибка при попытке достать ключ, сисемная ошибка";
            $checked = "";
            $web_checked = "";
            $course = 60;

            $moduls = "<option></option>";
            $res = $mysqli->query("SELECT * FROM `packages` ORDER BY `type` DESC");
            if($res->num_rows > 0) {
                $row = $mysqli->assoc($res);
                do {
                    $row['type'] = strtoupper($row['type']);
                    $moduls .= "<option value='{$row['id']}'>{$row['type']} - {$row['price']}$</option>";
                }
                while($row = $mysqli->assoc($res));
            }
            else {
                $moduls .= "<option>Пакетов нет</option>";
            }

            $course_tmp = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'course' LIMIT 1");
            if($course_tmp->num_rows == 1) {
                $course_tmp = $mysqli->assoc($course_tmp);
                $course = $course_tmp['value'];
            }

            $key = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'key' LIMIT 1");
            $minutes = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'quantity_minutes' LIMIT 1");
            if($key->num_rows == 1 && $minutes->num_rows == 1) {
                $key = $mysqli->assoc($key);
                $key_val = $key['value'];
                $minutes = $mysqli->assoc($minutes);
                $minutes_val = $minutes['value'];
            }

            $a_time = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'a_time' LIMIT 1");
            if($a_time->num_rows == 1) {
                $a_time = $mysqli->assoc($a_time);
                $time_val = $a_time['value'];
            }

            $a_time = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_time' LIMIT 1");
            if($a_time->num_rows == 1) {
                $a_time = $mysqli->assoc($a_time);
                $web_time = $a_time['value'];
            }

            $is_check = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'demo' AND `value` = '1' LIMIT 1");
            if($is_check->num_rows == 1) {
                $checked = "checked";
            }

            $is_check = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo' AND `value` = '1' LIMIT 1");
            if($is_check->num_rows == 1) {
                $web_checked = "checked";
            }

            $worlds_list = "";
            $wl = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'tmp-list' LIMIT 1");
            if($wl->num_rows == 1) {
                $wl = $mysqli->assoc($wl);
                $worlds_list = $wl['value'];
            }

            $key_api = "";

            $key_a = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'api' LIMIT 1");
            if($key_a->num_rows == 1) {
                $key_a = $mysqli->assoc($key_a);
                $key_api =  $key_a['value'];
            }
            
            $elly_val = 0;
            $elly_type = "VIP";

            $elly = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'elly' LIMIT 1");
            if($elly->num_rows == 1) {
                $elly = $mysqli->assoc($elly);
                $elly_val = $elly['value'];
                if($elly_val == 1) {
                    $elly_type = "VIP месяц+";
                }
            }

            $base_size = $adds->baseOptimizationSize(DB_BASE);

            $wrap->change("key_api", $key_api);
            $wrap->change("elly_val", $elly_val);
            $wrap->change("elly_type", $elly_type);

            $wrap->change("base_size", $base_size);
            $wrap->change("a_time", $time_val);
            $wrap->change("web_time", $web_time);
            $wrap->change("worlds_list", $worlds_list);
            $wrap->change("packages_list", $moduls);
            $wrap->change("course", $course);
            $wrap->change("checked", $checked);
            $wrap->change("web_checked", $web_checked);
            $wrap->change("key_name", $key_val);
            $wrap->change("key_time", $minutes_val);
            echo $wrap->show();
        }
        else {
            $lock = new Reader("default");
            $lock->view("admin/lock");
            $lock->change("uri", URI);
            echo $lock->show();
        }
    }
}
?>