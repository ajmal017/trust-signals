<?php
class News extends Core {
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
            if($action == "remove-news" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `economic_news` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "add-news" && isset($_POST['time'])) {
                $time = $_POST['time'];
                if(preg_match("/^\d{4}-\d{2}-\d{2}\ \d{2}:\d{2}$/", $time)) {
                    $part1 = explode(" ", $time);
                    $part1 = $part1[0];
                    $part2 = explode(" ", $time);
                    $part2 = $part2[1];
                    $part1 = explode("-", $part1);
                    $part2 = explode(":", $part2);
                    $time_translate = mktime($part2[0],$part2[1], 0, $part1[1], $part1[2], $part1[0]);
                    $mysqli->query("INSERT INTO `economic_news` (`date`) VALUES('{$time_translate}')");
                    $last = $mysqli->query("SELECT `id`, `date` FROM `economic_news` ORDER BY `id` DESC LIMIT 1");
                    if($last->num_rows == 1) {
                        $last_id = $mysqli->assoc($last);
                        $id = $last_id['id'];
                        $time = $last_id['date'];
                        $time = date("Y-m-d H:i", $time);
                        $inf = new Reader("default");
                        $inf->view("admin/news");
                        $inf->change("id", $id);
                        $inf->change("date", $time);
                        echo $inf->show();
                    }
                    else {
                        echo 'empty';
                    }
                }
                else {
                    echo 'format';
                }
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>