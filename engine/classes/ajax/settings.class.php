<?php
class Settings extends Core {
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
            if($action == "find-user") {
                $name = $adds->siftText($_POST['name']);
                $search = $mysqli->query("SELECT `img`, `id`, `name` FROM `users` WHERE `name` LIKE '%{$name}%' LIMIT 3");
                if($search->num_rows > 0) {
                    $row = $mysqli->assoc($search);
                    do {
                        $usr = $row['name'];
                        $id = $row['id'];
                        $img = $row['img'];

                        if(empty($img)) {
                            $img = URI."/engine/templates/default/img/author.jpg";
                        }

                        echo "<div class='find-user-element' data-id='{$id}' data-name='{$usr}'>
                                  <img src='{$img}' />
                                  <div class='find-element-name'>
                                        {$usr}
                                        <div class='find-element-id'>ID: {$id}</div>
                                  </div>
                                  <div class='clear-stop'></div>
                              </div>";
                    }
                    while($row = $mysqli->assoc($search));
                }
                else {
                    echo "<p>Нет совпадений</p>";
                }
            }
            elseif($action == "cleaner") {
                $end = 10;

                # WEB HISTORY
                $mysqli->query("DELETE FROM `web_history` WHERE date_format(`date`, '%Y-%m-%d') <> '{$date}'");

                # QUOTES
                $mysqli->query("DELETE FROM `quotes` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");
                #15
                $mysqli->query("DELETE FROM `quotes_15` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");
                #30
                $mysqli->query("DELETE FROM `quotes_30` WHERE date_format(from_unixtime(`lasttime`), '%Y-%m-%d') <> '{$date}'");

                # STATS
                $mysqli->query("DELETE FROM `signals_stats` WHERE `date` <> '{$date}'");

                # MAILS
                $last = $mysqli->query("SELECT `id` FROM `_mails` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= $end; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `_mails` WHERE `id` < '{$last}'");

                # ALERTS
                $mysqli->query("DELETE FROM `alerts` WHERE 1");

                # ELLY
                $last = $mysqli->query("SELECT `id` FROM `elly` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= $end; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `elly` WHERE `id` < '{$last}'");

                # ADMIN HISTORY ELLY
                $last = $mysqli->query("SELECT `id` FROM `history_elly` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= $end; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `history_elly` WHERE `id` < '{$last}'");

                # SIGNALS AMOUNT
                $last = $mysqli->query("SELECT `id` FROM `signals_amount` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= $end; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `signals_amount` WHERE `id` < '{$last}'");

                # OLD QUOTES
                $last = $mysqli->query("SELECT `id` FROM `catirovki` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `catirovki` WHERE `id` < '{$last}'");
                #2
                $last = $mysqli->query("SELECT `id` FROM `eurgbp` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `eurgbp` WHERE `id` < '{$last}'");
                #3
                $last = $mysqli->query("SELECT `id` FROM `eurjpy` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `eurjpy` WHERE `id` < '{$last}'");
                #4
                $last = $mysqli->query("SELECT `id` FROM `gbpjpy` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `gbpjpy` WHERE `id` < '{$last}'");
                #5
                $last = $mysqli->query("SELECT `id` FROM `gbpusd` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `gbpusd` WHERE `id` < '{$last}'");
                #6
                $last = $mysqli->query("SELECT `id` FROM `usdjpy` ORDER BY `id` DESC LIMIT 1"); if($last->num_rows == 1) { $last -= 20; if($last < 0) { $last = 0; } } else { $last = 0; }
                $mysqli->query("DELETE FROM `usdjpy` WHERE `id` < '{$last}'");
                echo $adds->baseOptimizationSize(DB_BASE);
            }
            elseif($action == 'elly' && isset($_POST['elly'])) {
                $elly = $adds->toInteger($_POST['elly']);
                if($elly == 0 || $elly == 1) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$elly}' WHERE `title` = 'elly'");
                    echo 'success';
                }
            }
            elseif($action == 'add-package' && isset($_POST['price']) && isset($_POST['type']) && isset($_POST['time'])) {
                $type = $_POST['type'];
                $price = $adds->toInteger($_POST['price']);
                $time = $adds->toInteger($_POST['time']);
                if($type == 'vip') { $type = 'vip'; } else { $type = 'cabinet'; }
                if($price > 0 && $time > 0) {
                    $mysqli->query("INSERT INTO `packages` (`type`, `price`, `time`) VALUES ('{$type}', '{$price}', '{$time}')");
                    echo 'success';
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == 'remove-package' && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `packages` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == 'api' && isset($_POST['key'])) {
                $key = $adds->siftText($_POST['key']);
                $mysqli->query("UPDATE `settings` SET `value` = '{$key}' WHERE `title` = 'api'");
                echo 'success';
            }
            elseif($action == 'get-includes') {
                $moduls = "";
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
                echo $moduls;
            }
            elseif($action == 'change-demo' && isset($_POST['demo-val'])) {
                $course = $adds->toInteger($_POST['demo-val']);
                if($course > 0) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$course}' WHERE `title` = 'a_time'");
                    echo 'success';
                }
            }
            elseif($action == 'change-web-demo' && isset($_POST['demo-val'])) {
                $course = $adds->toInteger($_POST['demo-val']);
                if($course > 0) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$course}' WHERE `title` = 'web_time'");
                    echo 'success';
                }
            }
            elseif($action == 'change-course' && isset($_POST['course-val'])) {
                $course = $adds->toInteger($_POST['course-val']);
                if($course > 0) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$course}' WHERE `title` = 'course'");
                    echo 'success';
                }
            }
            elseif($action == 'change-worlds' && isset($_POST['worlds-val'])) {
                $worlds = $adds->siftText($_POST['worlds-val']);
                if(!empty($worlds)) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$worlds}' WHERE `title` = 'tmp-list'");
                    echo 'success';
                }
            }
            elseif($action == 'systems' && isset($_POST['id']) && isset($_POST['val'])) {
                $id = $adds->toInteger($_POST['id']);
                $val = $_POST['val'];
                if($val == '1') {
                    $val = '1';
                }
                else {
                    $val = '0';
                }
                $mysqli->query("UPDATE `pay_systems` SET `status` = '{$val}' WHERE `id` = '{$id}'");
                echo 'success';
            }
            elseif($action == 'demo' && isset($_POST['val'])) {
                $val = $_POST['val'];
                if($val == '1') {
                    $val = '1';
                }
                else {
                    $val = '0';
                }
                $mysqli->query("UPDATE `settings` SET `value` = '{$val}' WHERE `title` = 'demo'");
                echo 'success';
            }
            elseif($action == 'web-demo' && isset($_POST['val'])) {
                $val = $_POST['val'];
                if($val == '1') {
                    $val = '1';
                }
                else {
                    $val = '0';
                }
                $mysqli->query("UPDATE `settings` SET `value` = '{$val}' WHERE `title` = 'web_demo'");
                echo 'success';
            }
            elseif($action == 'install-key' && isset($_POST['key']) && isset($_POST['time'])) {
                $key = $adds->siftText($_POST['key']);
                $time = $adds->toInteger($_POST['time']);
                if($time > 0 && !empty($key)) {
                    $mysqli->query("UPDATE `settings` SET `value` = '{$key}' WHERE `title` = 'key' LIMIT 1");
                    $mysqli->query("UPDATE `settings` SET `value` = '{$time}' WHERE `title` = 'quantity_minutes' LIMIT 1");
                    echo 'success';
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == 'install-rules') {
                $id = $adds->siftText($_POST['id']);
                $isset = $mysqli->query("SELECT `group`, `id` FROM `users` WHERE `group` = 'moder' OR `group` = 'admin' AND `id` = '{$id}' LIMIT 1");
                if($isset->num_rows == 1) {
                    exit("rules was install");
                }
                $mysqli->query("UPDATE `users` SET `group` = 'moder' WHERE `id` = '{$id}'");
            }
            elseif($action == 'uninstall-rules') {
                $id = $adds->siftText($_POST['id']);
                $isset = $mysqli->query("SELECT `group`, `id` FROM `users` WHERE `group` = 'user' AND `id` = '{$id}' LIMIT 1");
                if($isset->num_rows == 1) {
                    exit("rules was uninstall");
                }
                $mysqli->query("UPDATE `users` SET `group` = 'user' WHERE `id` = '{$id}'");
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>
