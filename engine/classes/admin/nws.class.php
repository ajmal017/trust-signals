<?php
class Nws extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Новости - Панель управления";
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
        $this->templateEdit("title_content", "Новости");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {
            $data = new Reader("default");
            $data->view("admin/news_home");
            $limit = 10;
            $str_res = "";
            $foundkey = 0;
            if($foundkey) {
                $id = $adds->toInteger($_GET['id']);
                $search_atricle = $mysqli->query("SELECT * FROM `home_news` WHERE `id` = '{$id}' LIMIT 1");
                if($search_atricle->num_rows == 0) $foundkey = 0;
            }
            if($foundkey) {
                // empty
            }
            else {
                $strs = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `home_news` ORDER BY `id` DESC LIMIT {$limit}");
                $am = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `home_news`")->num_rows;
                if($strs->num_rows > 0) {
                    $row = $mysqli->assoc($strs);
                    $str_res = "<div class='news-full-box'><div id='strategies-list'>";
                    do {
                        $moder = "";
                        $ok = "<a class='edit-str' href='".URI."/ednews_{$row['id']}/"."' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Редактировать'><span class='glyphicon glyphicon-pencil'></span></a>";
                        if($user['group'] == 'admin' || $user['group'] == 'moder') {
                            $moder = "{$ok} <a class='remove-news' href='#' data-id='".$row['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                        }
                        $desc = strip_tags($row['text']);
                        if(strlen($desc) > 400) {
                            $desc = substr($desc, 0, 400).'...';
                        }
                        $tmp = new Reader("default");
                        $tmp->view("pages/news_list");
                        $type_str = mb_strtolower($row['type']);
                        $tmp->change("title", $row['title']);
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
                    $str_res->change("text", "Список новостей в данный момент пуст");
                    $str_res = $str_res->show();
                }
            }
            if(isset($_GET['id'])) {
                $id = $adds->toInteger($_GET['id']);
                $exists = $mysqli->query("SELECT `id` FROM `home_news` WHERE `id` = '{$id}'")->num_rows;
                if($exists) {
                    $str = $mysqli->query("SELECT `id`, `title`, `text` FROM `home_news` WHERE `id` = '{$id}'");
                    $str = $mysqli->assoc($str);
                    $v = new Reader("default");
                    $v->view("admin/news_edit");
                    $v->change("title", $str['title']);
                    $v->change("description", $str['text']);
                    $v->change("id", $str['id']);
                    $v->change("URI", URI);
                    $str_res = $v->show();
                }
            }
            elseif(isset($_GET['add'])) {
                $v = new Reader("default");
                $v->view("admin/news_add");
                $v->change("URI", URI);
                $str_res = $v->show();
            }

            $data->change("news", $str_res);
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