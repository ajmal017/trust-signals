<?php
class Users_adm extends Core {
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
            if($action == "remove-user" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `users` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "lock-user" && isset($_POST['id']) && isset($_POST['message'])) {
                $id = $adds->toInteger($_POST['id']);
                $message = $adds->siftText($_POST['message']);
                $mysqli->query("UPDATE `users` SET `banned` = '{$message}' WHERE `id` = '{$id}'");
            }
            elseif($action == "unlock-user" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                $mysqli->query("UPDATE `users` SET `banned` = '' WHERE `id` = '{$id}'");
            }
            elseif($action == "activate-all") {
                $mysqli->query("UPDATE `users` SET `confirm` = '1'");
                echo 'success';
            }
            elseif($action == "activate" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                $mysqli->query("UPDATE `users` SET `confirm` = '1' WHERE `id` = '{$id}'");
                echo 'success';
            }
            elseif($action == "search-orders" && isset($_POST['title'])) {
                $title = $adds->siftText($_POST['title']);
                $where = "";
                if(!empty($title)) {
                    $str = $title;
                    $where = "WHERE `users`.`name` LIKE '%{$str}%' OR `users`.`email` LIKE '%{$str}%'";
                }
                $usr_tmp = $mysqli->query("SELECT `orders`.`id`, `user_id`, `name`, `orders`.`date`, `summ`, `package_id`, `orders`.`status`
                                            FROM
                                              `orders`
                                              LEFT OUTER JOIN
                                              `users`
                                                ON `orders`.`user_id` = `users`.`id`
                                            {$where} ORDER BY `id` DESC LIMIT 0, 10");
                $amount = $mysqli->query("SELECT `orders`.`id`, `user_id`, `name`, `orders`.`date`, `summ`, `package_id`, `orders`.`status`
                                            FROM
                                              `orders`
                                              LEFT OUTER JOIN
                                              `users`
                                                ON `orders`.`user_id` = `users`.`id`
                                            {$where}")->num_rows;
                if($usr_tmp->num_rows > 0) {
                    $order = $mysqli->assoc($usr_tmp);
                    $ord = "";
                    do {
                        $user_data = $mysqli->query("SELECT `email`, `id` FROM `users` WHERE `id` = '{$order['user_id']}'");
                        $user_data = $mysqli->assoc($user_data);
                        $inf = new Reader("default");
                        $inf->view("admin/order");
                        if($order['status'] == '1') {
                            $inf->change("status", "<span class='label label-success'>Оплачен <span class='glyphicon glyphicon-ok'></span></span>");
                            $inf->change("confirm", "");
                        }
                        else {
                            $inf->change("status", "<span class='label label-warning'>Обрабатывается <span class='glyphicon glyphicon-refresh'></span></span>");
                            $inf->change("confirm", "<span data-toggle=\"tooltip\" data-placement=\"top\" title=\"Подтвердить\" data-package=\"{$order['package_id']}\" data-id=\"{$order['id']}\" class=\"confirm-order moderation-link label label-success\"><span class=\"glyphicon glyphicon-ok\"></span></span>");
                        }
                        $inf->change("id", $order['id']);
                        $inf->change("user_id", $order['user_id']);
                        $inf->change("date", $order['date']);
                        $inf->change("summ", $order['summ']);
                        $inf->change("pack_id", $order['package_id']);
                        $inf->change("email", $user_data['email']);
                        $inf->change("uri", URI);
                        $ord .= $inf->show();
                    }
                    while($order = $mysqli->assoc($usr_tmp));
                    $ord .= '<tr><td colspan="5">'.$adds->pageNav(1, $amount, str_replace(' ', '+', $title).'_')."</td></tr>";
                    echo $ord;
                }
                else {
                    $inf = new Reader("default");
                    $inf->view("cabinet/infobox");
                    $inf->change("text", "Список записей по данному запросу пуст");
                    echo '<tr><td colspan="5">'.$inf->show()."</td></tr>";
                }
            }
            elseif($action == "search" && isset($_POST['title'])) {
                $title = $adds->siftText($_POST['title']);
                $where = "";
                if(!empty($title)) {
                    $str = $title;
                    $where = "WHERE `name` LIKE '%$str%' OR `email` LIKE '%$str%'";
                }
                $usr_tmp = $mysqli->query("SELECT * FROM `users` {$where} ORDER BY `id` DESC LIMIT 0, 10");
                $amount = $mysqli->query("SELECT `id` FROM `users` {$where}")->num_rows;
                if($usr_tmp->num_rows > 0) {
                    $u = $mysqli->assoc($usr_tmp);
                    $usr = "";
                    do {
                        $img = $u['img'];
                        if(empty($img)) {
                            $img = URI."/engine/templates/default/img/author.jpg";
                        }
                        $ub = new Reader("default");
                        $ub->view("admin/usr_rec");
                        $online = '<span class="label label-danger">offline</span>';
                        $m_lasttime = round((time() - $u['lasttime']) / 60);
                        if($m_lasttime <= 3)
                            $online = '<span class="label label-success">online</span>';

                        $soc_url = 'Не указана';
                        if(!empty($u['soc_url'])) { $soc_url = $u['soc_url']; }
                        $reg_from = "trust-signals.com";
                        if($u['auth_type'] == 'vk') $reg_from = "ВКонтакте";
                        if($u['auth_type'] == 'ok') $reg_from = "Однокласники";
                        if($u['auth_type'] == 'ya') $reg_from = "Яндекс Почта";

                        $btn_act = "";
                        if($u['confirm'] == '0') {
                            $btn_act = '<span data-toggle="tooltip" data-placement="top" title="Активировать" data-id="'.$u['id'].'" class="activate-user moderation-link label label-danger"><span class="glyphicon glyphicon-ok"></span></span>';
                        }
                        $ub->change("activate_user", $btn_act);

                        $ub->change("address", $soc_url);
                        $ub->change("from_reg", $reg_from);
                        $ub->change("user_img", $img);

                        $ub->change("user_id", $u['id']);
                        $ub->change("email", $u['email']);
                        $ub->change("status", $online);
                        if($u['time_vip'] > 0) {
                            $ub->change("type", "<span class='glyphicon glyphicon-certificate golden-color'></span>");
                        }
                        else {
                            $ub->change("type", "");
                        }
                        $ub->change("timeleft", $adds->timeleft($u['timeleft']));
                        $ub->change("time_vip", $adds->timeleft($u['time_vip']));
                        $ub->change("name", $u['name']);
                        $ub->change("date", $u['date']);
                        $ub->change("user_img", $img);

                        if(!empty($u['banned'])) {
                            $ub->change("banned", "<span class='unlock-banned-usr' data-id='{$u['id']}'><span class='fa fa-unlock'></span> Убрать бан</span> | <a href='#' data-message='{$u['banned']}' class='show-banned-message'>причина</a>");
                        }
                        else {
                            $ub->change("banned", "<span class='lock-banned-usr' data-id='{$u['id']}'><span class='fa fa-lock'></span> Блокировать</span>");
                        }

                        $usr .= $ub->show();
                    }
                    while($u = $mysqli->assoc($usr_tmp));
                    $usr .= '<tr><td colspan="5">'.$adds->pageNav(1, $amount, str_replace(' ', '+', $title).'_')."</td></tr>";
                    echo $usr;
                }
                else {
                    $inf = new Reader("default");
                    $inf->view("cabinet/infobox");
                    $inf->change("text", "Список пользователей по данному запросу пуст");
                    echo '<tr><td colspan="5">'.$inf->show()."</td></tr>";
                }
            }
            elseif($action == "reload-base") {
                $users = $mysqli->query("SELECT `name`, `email`, `id` FROM `users` ORDER BY `id` DESC LIMIT 10000");
                $cont = "";
                if($users->num_rows > 0) {
                    $usr = $mysqli->assoc($users);
                    do {
                        $cont .= "{$usr['name']};{$usr['email']}\n";
                    }
                    while($usr = $mysqli->assoc($users));
                }
                $file = ROOT.'/engine/classes/base/users.xlsx';
                echo $file;
                file_put_contents($file, $cont);
            }
            elseif($action == "add-timeleft") {
                if(isset($_POST['time']) && isset($_POST['id'])) {
                    $time = $adds->siftText($_POST['time']);
                    $id = $adds->toInteger($_POST['id']);
                    if($id != 0) {
                        $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + '{$time}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo "error";
                }
            }
            elseif($action == "add-time-vip") {
                if(isset($_POST['time']) && isset($_POST['id'])) {
                    $time = $adds->siftText($_POST['time']);
                    $id = $adds->toInteger($_POST['id']);
                    if($id != 0) {
                        if($time == '111') {
                            $time = 43200;
                            $mysqli->query("UPDATE `users` SET `vip_1` = '1' WHERE `id` = '{$id}'");
                        }
                        $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` + '{$time}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo "error";
                }
            }
            elseif($action == "change-timeleft") {
                if(isset($_POST['time']) && isset($_POST['id'])) {
                    $time = $adds->siftText($_POST['time']);
                    $id = $adds->toInteger($_POST['id']);
                    if($id != 0) {
                        $mysqli->query("UPDATE `users` SET `timeleft` = '{$time}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo "error";
                }
            }
            elseif($action == "change-time-vip") {
                if(isset($_POST['time']) && isset($_POST['id'])) {
                    $time = $adds->siftText($_POST['time']);
                    $id = $adds->toInteger($_POST['id']);
                    if($id != 0) {
                        if($time == '111') {
                            $time = 43200;
                            $mysqli->query("UPDATE `users` SET `vip_1` = '1' WHERE `id` = '{$id}'");
                        }
                        $mysqli->query("UPDATE `users` SET `time_vip` = '{$time}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo "error";
                }
            }
            elseif($action == "change-email") {
                if(isset($_POST['email']) && isset($_POST['id'])) {
                    $email = $adds->siftText($_POST['email']);
                    $id = $adds->toInteger($_POST['id']);
                    if(!empty($email) && $id != 0) {
                        $mysqli->query("UPDATE `users` SET `email` = '{$email}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "change-pass") {
                if(isset($_POST['password']) && isset($_POST['id'])) {
                    $pass = $_POST['password'];
                    $id = $adds->toInteger($_POST['id']);
                    if(!empty($pass)) {
                        $pass = md5($pass);
                        $mysqli->query("UPDATE `users` SET `password` = '{$pass}' WHERE `id` = '{$id}'");
                        echo 'success';
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>