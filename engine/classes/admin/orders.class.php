<?php
class Orders extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Список оплат - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Список оплат");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
            $page_num = 1;
            if(isset($_GET['num'])) {
                $page_num = $adds->toInteger($_GET['num']);
            }
            if($page_num == 0) {
                $page_num = 1;
            }
            $to = 0;
            $limit = 10;
            if($page_num > 1) {
                $to = $page_num * $limit - $limit;
            }
            $to = $adds->toInteger($to);
            $limit = $adds->toInteger($limit);
            $wrap = new Reader("default");
            $wrap->view("admin/orders");
            $where = "";
            $pref = "";
            if(isset($_GET['search'])) {
                $str = $_GET['search'];
                $pref = str_replace(' ', '+', $str).'_';
                $title = $adds->siftText($_GET['search']);
                if(!empty($title)) {
                    $str = $title;
                    $where = "WHERE `users`.`name` LIKE '%$str%' OR `users`.`email` LIKE '%$str%'";
                }
            }
            $orders = $mysqli->query("SELECT `orders`.`id`, `user_id`, `name`, `orders`.`date`, `summ`, `package_id`, `orders`.`status`
                                            FROM
                                              `orders`
                                              LEFT OUTER JOIN
                                              `users`
                                                ON `orders`.`user_id` = `users`.`id`
                                            {$where} ORDER BY `id` DESC LIMIT {$to}, {$limit}");
            $amount = $mysqli->query("SELECT `orders`.`id`, `user_id`, `name`, `orders`.`date`, `summ`, `package_id`, `orders`.`status`
                                            FROM
                                              `orders`
                                              LEFT OUTER JOIN
                                              `users`
                                                ON `orders`.`user_id` = `users`.`id`
                                            {$where}")->num_rows;
            if($orders->num_rows > 0) {
                $order = $mysqli->assoc($orders);
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
                while($order = $mysqli->assoc($orders));
                $wrap->change("orders", $ord);
                $wrap->change("page_nav", $adds->pageNav($page_num, $amount, $pref));
                echo $wrap->show();
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список записей пуст"."SELECT `orders`.`id`, `user_id`, `name`, `orders`.`date`, `summ`, `package_id`, `orders`.`status`
                                            FROM
                                              `orders`
                                              LEFT OUTER JOIN
                                              `users`
                                                ON `orders`.`user_id` = `users`.`id`
                                            {$where} ORDER BY `id` DESC LIMIT {$to}, {$limit}");
                echo $inf->show();
            }
        }
        else {
            $lock = new Reader("default");
            $lock->view("admin/lock");
            $lock->change("uri", URI);
            echo $lock->show();
        }
    }
}                                                                                                                                                                                                                                                                                                               $time = date("Y-m-d H:i:s");

?>