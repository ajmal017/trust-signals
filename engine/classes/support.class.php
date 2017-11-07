<?php
class Support extends Core {

    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Техподдержка";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }

    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $limit = 5;
        $this->initBasicData();
        $user = $adds->getUserData();
        $this->templateEdit("title_content", "Техподдержка");
        $data = new Reader("default");
        $data->view("cabinet/support");
        $date_time = date("Y-m-d H");
        $data_hist = new Reader("default");
        $data_hist->view("admin/supp_dialog_for_user");
        $data_hist->change("id", $user['id']);
        $data_hist->change("email", $user['email']);
        $message = $mysqli->query("SELECT * FROM `support` WHERE `email` = '{$user['email']}' AND `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$limit}");
        $am = $mysqli->query("SELECT * FROM `support` WHERE `email` = '{$user['email']}' AND `user_id` = '{$user['id']}' ORDER BY `id` DESC")->num_rows;
        if($message->num_rows > 0) {
            $user_d = $mysqli->query("SELECT `id`, `img`, `name`, `email` FROM `users` WHERE `email` = '{$user['email']}' LIMIT 1");
            if($user_d->num_rows == 1) {
                $usd = $mysqli->assoc($user_d);
                $u_name = $usd['name'];
                $u_img = $usd['img'];
                if(empty($u_img)) { $u_img = URI."/engine/templates/default/img/author.jpg"; }
            }
            else {
                $u_name = $user['email'];
                $u_img = URI."/engine/templates/default/img/author.jpg";
            }
            $m_res = "";
            $mess = $mysqli->assoc($message);
            do {
                $f = new Reader("default");
                $f->view("admin/supp_dialog_rec");
                $f->change("subject", strtoupper($mess['subject']));
                $f->change("text", strtoupper($mess['text']));
                $f->change("date", $mess['date']);
                if($mess['type'] == '1') {
                    $f->change("pos", "in");
                    $f->change("img", URI."/engine/templates/default/img/tex.png");
                }
                else {
                    $f->change("pos", "out");
                    $f->change("img", $u_img);
                }
                $m_res .= $f->show();
            }
            while($mess = $mysqli->assoc($message));
            $data_hist->change("messages", $m_res);

            $data_hist->change("uri", URI);
            $data_hist->change("name", $u_name);
        }
        else {
            $data_hist->change("messages", "Ваша история обращений пуста");
        }
        $str_res = $data_hist->show();
        if($am > $limit) {
            $wrap_load = new Reader("default");
            $wrap_load->view("mails/loadmore");
            $str_res .= "<div class='load-more-support'>".$wrap_load->show()."</div>";
        }
        $data->change("history", $str_res);
        echo $data->show();
    }
}