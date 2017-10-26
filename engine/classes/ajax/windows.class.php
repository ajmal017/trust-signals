<?php
class Windows extends Core {
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
            if($action == "change-window" && isset($_POST['time']) && isset($_POST['title']) && isset($_POST['lang']) && isset($_POST['text']) && isset($_POST['id'])) {
                $title = $adds->siftText($_POST['title']);
                $text = stripslashes($_POST['text']);
                $lang = $adds->siftText($_POST['lang']);
                $time = $adds->toInteger($_POST['time']);
                $id = $adds->toInteger($_POST['id']);
                if($time && !empty($lang) && !empty($title) && !empty($text) && $id != 0) {
                    $mysqli->query("UPDATE `windows` SET `time` = '{$time}', `title` = '{$title}', `lang` = '{$lang}', `text` = '{$text}' WHERE `id` = '{$id}'");
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-window" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `windows` WHERE `id` = '{$id}'");
                    $inf = new Reader("default");
                    $inf->view("cabinet/infobox");
                    $inf->change("text", "Список записей пуст");
                    echo $inf->show();
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "add-window" && isset($_POST['title']) && isset($_POST['time']) && isset($_POST['lang']) && isset($_POST['text'])) {
                $title = $adds->siftText($_POST['title']);
                $text = stripslashes($_POST['text']);
                $lang = $adds->siftText($_POST['lang']);
                $time = $adds->toInteger($_POST['time']);
                if(!empty($lang) && !empty($title) && !empty($text) && $time) {
                    $mysqli->query("INSERT INTO `windows` (`title`, `text`, `lang`, `time`) VALUES('{$title}', '{$text}', '{$lang}', '{$time}')");
                    $last = $mysqli->query("SELECT `id` FROM `windows` ORDER BY `id` DESC LIMIT 1");
                    if($last->num_rows == 1) {
                        $last_id = $mysqli->assoc($last);
                        $last_id = $last_id['id'];
                        $inf = new Reader("default");
                        $inf->view("admin/window");
                        $inf->change("id", $last_id);
                        $inf->change("title", $title);
                        $inf->change("lang", $lang);
                        $inf->change("text", $text);
                        $inf->change("lang_big", strtoupper($lang));
                        echo $inf->show();
                    }
                    else {
                        echo 'empty';
                    }
                }
                else {
                    echo 'empty';
                }
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>