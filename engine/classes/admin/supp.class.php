<?php
class Supp extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Техподдержка - Панель управления";
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
        $this->templateEdit("title_content", "Техподдержка");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {
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
            if(isset($_GET['str'])) {
                $email = explode(" ", $_GET['str']);
                $id = $adds->toInteger($email[1]);
                $email = $adds->siftText($email[0]);
                $data = new Reader("default");
                $data->view("admin/supp_dialog");
                $data->change("id", $id);
                $data->change("email", $email);
                $message = $mysqli->query("SELECT * FROM `support` WHERE `email` = '{$email}' AND `user_id` = '{$id}' ORDER BY `id` DESC");
                if($message->num_rows > 0) {
                    $mysqli->query("UPDATE `support` SET `status` = '1' WHERE `email` = '{$email}' AND `user_id` = '{$id}'");
                    $user_d = $mysqli->query("SELECT `id`, `img`, `name`, `email` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                    if($user_d->num_rows == 1) {
                        $usd = $mysqli->assoc($user_d);
                        $u_name = $usd['name'];
                        $u_img = $usd['img'];
                        if(empty($u_img)) { $u_img = URI."/engine/templates/default/img/author.jpg"; }
                    }
                    else {
                        $u_name = $email;
                        $u_img = URI."/engine/templates/default/img/author.jpg";
                    }
                    $m_res = "";
                    $mess = $mysqli->assoc($message);
                    do {
                        $f = new Reader("default");
                        $f->view("admin/supp_dialog_rec");
                        $f->change("subject", strtoupper($mess['subject']));
                        $f->change("date", $mess['date']);
                        $f->change("text", strtoupper($mess['text']));
                        if($mess['type'] == '1') {
                            $f->change("pos", "out");
                            $f->change("img", $user['img']);
                        }
                        else {
                            $f->change("pos", "in");
                            $f->change("img", $u_img);
                        }
                        $m_res .= $f->show();
                    }
                    while($mess = $mysqli->assoc($message));
                    $data->change("messages", $m_res);

                    $data->change("uri", URI);
                    $data->change("name", $u_name);
                    echo $data->show();
                }
                else {
                    $adds->redirect(URI."/supp/");
                }
            }
            else {
                $fq = $mysqli->query("SELECT DISTINCT `user_id`, `email` FROM `support` ORDER BY `id` DESC LIMIT {$to}, {$limit}");
                $amount = $mysqli->query("SELECT DISTINCT `user_id`, `email` FROM `support`")->num_rows;
                if($fq->num_rows > 0) {
                    $rec = "";
                    $data = new Reader("default");
                    $data->view("admin/support");
                    $f = $mysqli->assoc($fq);
                    do {
                        $supp = $mysqli->query("SELECT `email`, `user_id`, `id`, `text`, `subject`, `status` FROM `support` WHERE `user_id` = '{$f['user_id']}' AND `email` = '{$f['email']}' ORDER BY `id` DESC LIMIT 1");
                        $supp = $mysqli->assoc($supp);
                        $inf = new Reader("default");
                        $inf->view("admin/supp_rec");
                        $inf->change("email", $f['email']);
                        $inf->change("URI", URI);
                        $inf->change("user_id", $f['user_id']);
                        $inf->change("subject", $supp['subject']);
                        $inf->change("text", $supp['text']);
                        $inf->change("id", $supp['id']);
                        if($supp['status']) {
                            $inf->change("status_class", "");
                        }
                        else {
                            $inf->change("status_class", "user-admin-box-status");
                        }
                        $rec .= $inf->show();
                    }
                    while($f = $mysqli->assoc($fq));
                    $data->change("records", $rec);
                    echo $data->show();
                    echo $adds->pageNav($page_num, $amount);
                }
                else {
                    $inf = new Reader("default");
                    $inf->view("cabinet/infobox");
                    $inf->change("text", "Список записей пуст");
                    echo $inf->show();
                }
            }
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