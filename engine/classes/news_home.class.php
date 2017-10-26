<?php
class News_home extends Core {
    public function getTitle() {
        echo "Новости";
    }
    public function getContent() {
        $adds = new Additions();
        if($adds->isAuth()) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $this->templateEdit("title_content", "Новости");
            $user = $adds->getUserData();
            $data = new Reader("default");
            $data->view("pages/news");
            $limit = 10;
            $str_res = "";
            $foundkey = 0;
            if(isset($_GET['id'])) { $foundkey = 1; }
            if($foundkey) {
                $id = $adds->toInteger($_GET['id']);
                $search_atricle = $mysqli->query("SELECT * FROM `home_news` WHERE `id` = '{$id}' LIMIT 1");
                if($search_atricle->num_rows == 0) $foundkey = 0;
            }
            if($foundkey) {
                $row = $mysqli->assoc($search_atricle);
                $desc = strip_tags($row['text']);
                if(strlen($desc) > 400) {
                    $desc = substr($desc, 0, 400).'...';
                }
                $tmp = new Reader("default");
                $tmp->view("pages/watch_news");
                $tmp->change("description", $desc);
                $tmp->change("title", $row['title']);
                $tmp->change("text", $row['text']);
                $tmp->change("id", $row['id']);
                $tmp->change("img", $row['img']);
                $tmp->change("date", $row['date']);
                $tmp->change("URI", URI);
                $str_res = $tmp->show();
            }
            else {
                $strs = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `home_news`ORDER BY `id` DESC LIMIT {$limit}");
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
                        $str_res .= "<div id='load-more'>".$wrap_load->show()."</div>";
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

            $str_cabinet = $str_res;


            $data->change("news", $str_cabinet);
            echo $data->show();
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>