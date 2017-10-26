<?php
class Strs extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Стратегии - Панель управления";
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
        $this->templateEdit("title_content", "Стратегии");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {
            $data = new Reader("default");
            $data->view("admin/strategies");
            $limit = 10;
            $str_res = "";
            $foundkey = 0;
            if($foundkey) {
                $id = $adds->toInteger($_GET['id']);
                $search_atricle = $mysqli->query("SELECT * FROM `strategies` WHERE `id` = '{$id}' LIMIT 1");
                if($search_atricle->num_rows == 0) $foundkey = 0;
            }
            if($foundkey) {
                // empty
            }
            else {
                $strs = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies` ORDER BY `id` DESC LIMIT {$limit}");
                $am = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies`")->num_rows;
                if($strs->num_rows > 0) {
                    $row = $mysqli->assoc($strs);
                    $str_res = "<div class='strategies-full-box'><div id='strategies-list'>";
                    do {
                        $moder = "";
                        $ok = "<a class='edit-str' href='".URI."/strs_{$row['id']}/"."' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Редактировать'><span class='glyphicon glyphicon-pencil'></span></a>";
                        if($user['group'] == 'admin' || $user['group'] == 'moder') {
                            $moder = "{$ok} <a class='remove-str' href='#' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                        }
                        $desc = strip_tags($row['text']);
                        if(strlen($desc) > 400) {
                            $desc = mb_substr($desc, 0, 400).'...';
                        }
                        $tmp = new Reader("default");
                        $tmp->view("pages/str_list");
                        $type_str = mb_strtolower($row['type']);
                        $tmp->change("title", $row['title']. " ({$type_str})");
                        $tmp->change("description", $desc);
                        $tmp->change("id", $row['id']);
                        $tmp->change("img", $row['img']);
                        $tmp->change("URI", URI);
                        $tmp->change("moder", $moder);
                        $str_res .= $tmp->show();
                    }
                    while($row = $mysqli->assoc($strs));
                    $str_res .= "</div>";
                    if($am > $limit) {
                        $wrap_load = new Reader("default");
                        $wrap_load->view("mails/loadmore");
                        $str_res .= $wrap_load->show();
                    }
                    $str_res .= "</div>";
                }
                else {
                    $str_res = new Reader("default");
                    $str_res->view("cabinet/infobox");
                    $str_res->change("text", "Список стратегий в данный момент пуст");
                    $str_res = $str_res->show();
                }
            }
            $videos = "";
            $limit = 4;
            $vids = $mysqli->query("SELECT `status`, `title`, `id`, `url`, `likes`, `user_id` FROM `videos` ORDER BY `status` ASC, `id` DESC LIMIT {$limit}");
            $am = $mysqli->query("SELECT `status`, `title`, `id`, `url`, `likes`, `user_id` FROM `videos`")->num_rows;
            if($vids->num_rows > 0) {
                $row = $mysqli->assoc($vids);
                $videos = "<div class='video-full-box'><div id='videos-list'>";
                do {
                    $title = $row['title'];
                    if(strlen($title) > 45) {
                        $title = mb_substr($title, 0, 45).'...';
                    }
                    $name = $mysqli->query("SELECT `name`, `id` FROM `users` WHERE `id` = '{$row['user_id']}' LIMIT 1");
                    if($name->num_rows) {
                        $name = $mysqli->assoc($name);
                        $name = $name['name'];
                    }
                    else {
                        $name = "Анонимно";
                    }
                    $moder = "";
                    $ok = "<a class='ok-video' href='#' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Утвердить'><span class='glyphicon glyphicon-ok'></span></a>";
                    if($user['group'] == 'admin' || $user['group'] == 'moder') {
                        if($row['status'] == '1') { $ok = ""; }
                        $moder = "{$ok} <a class='remove-video' href='#' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                    }
                    $tmp = new Reader("default");
                    $tmp->view("pages/video");
                    $tmp->change("title", $title);
                    $tmp->change("name", $name);
                    $tmp->change("link", $row['url']);
                    $tmp->change("id", $row['id']);
                    $tmp->change("votes", $row['likes']);
                    $tmp->change("URI", URI);
                    $tmp->change("moder", $moder);
                    $videos .= $tmp->show();
                }
                while($row = $mysqli->assoc($vids));
                $videos .= "</div>";
                if($am > $limit) {
                    $wrap_load = new Reader("default");
                    $wrap_load->view("mails/loadmore");
                    $videos .= $wrap_load->show();
                }
                $videos .= "</div>";
            }
            else {
                $videos = "<p style='padding-top: 20px;'>Список стратегий от пользователей в данный момент пуст</p>";
            }
            if(isset($_GET['id'])) {
                $id = $adds->toInteger($_GET['id']);
                $exists = $mysqli->query("SELECT `id` FROM `strategies` WHERE `id` = '{$id}'")->num_rows;
                if($exists) {
                    $str = $mysqli->query("SELECT `id`, `title`, `text` FROM `strategies` WHERE `id` = '{$id}'");
                    $str = $mysqli->assoc($str);
                    $v = new Reader("default");
                    $v->view("admin/str_edit");
                    $v->change("title", $str['title']);
                    $v->change("description", $str['text']);
                    $v->change("id", $str['id']);
                    $v->change("URI", URI);
                    $videos = $v->show();
                }
            }
            elseif(isset($_GET['add'])) {
                $v = new Reader("default");
                $v->view("admin/str_add");
                $v->change("URI", URI);
                $videos = $v->show();
            }
            $data->change("videos", $videos);
            $data->change("strategies", $str_res);
            $data->change("URI", URI);
            echo $data->show();
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