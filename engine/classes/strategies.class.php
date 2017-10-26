<?php
class Strategies extends Core {
    public function getTitle() {
        echo "Стратегии торговли";
    }
    public function getContent() {
        $adds = new Additions();
        if($adds->isAuth()) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $this->templateEdit("title_content", "Стратегии торговли");
            $user = $adds->getUserData();
            $data = new Reader("default");
            $data->view("pages/strategies");
            $limit = 10;
            if(( $user['time_vip'] > 0 || $user['timeleft'] > 0 ) && $user['confirm'] == '1' /*&& date("l") != "Saturday" &&  date("l") != "Sunday"*/) {
                $str_res = "";
                if(( $user['time_vip'] > 0 || $user['timeleft'] > 0 )) {
                    $foundkey = 0;
                    if(isset($_GET['id'])) { $foundkey = 1; }
                    if($foundkey) {
                        $id = $adds->toInteger($_GET['id']);
                        $search_atricle = $mysqli->query("SELECT * FROM `strategies` WHERE `id` = '{$id}' LIMIT 1");
                        if($search_atricle->num_rows == 0) $foundkey = 0;
                    }
                    if($foundkey) {
                        $row = $mysqli->assoc($search_atricle);
                        $tmp = new Reader("default");
                        $tmp->view("pages/watch_str");
                        $tmp->change("title", $row['title']);
                        $tmp->change("text", $row['text']);
                        $tmp->change("id", $row['id']);
                        $tmp->change("img", $row['img']);
                        $tmp->change("date", $row['date']);
                        $tmp->change("URI", URI);
                        $str_res = $tmp->show();
                    }
                    else {
                        $strs = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies` WHERE `type` = 'cabinet' ORDER BY `id` DESC LIMIT {$limit}");
                        $am = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies` WHERE `type` = 'cabinet'")->num_rows;
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
                            $str_res->change("text", "Список стратегий в данный момент пуст");
                            $str_res = $str_res->show();
                        }
                    }
                }
                else {
                    $str_res = new Reader("default");
                    $str_res->view("cabinet/infobox");
                    $str_res->change("text", "Ваше время для базового и vip кабинета истекло | <a href='".URI."/buy/'>купить доступ здесь</a>");
                    $str_res = $str_res->show();
                }
                $str_cabinet = $str_res;
                if($user['timeleft'] <= 0 && $user['time_vip'] <= 0 ) {
                    $str_cabinet = new Reader("default");
                    $str_cabinet->view("cabinet/infobox");
                    $str_cabinet->change("text", "Ваше время для vip кабинета истекло | <a href='".URI."/buy/'>купить доступ здесь</a>");
                    $str_cabinet = $str_cabinet->show();
                }
                /* VIP */
                $strs = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies` WHERE `type` = 'vip' ORDER BY `id` DESC LIMIT {$limit}");
                $am = $mysqli->query("SELECT `type`, `title`, `img`, `id`, `text` FROM `strategies` WHERE `type` = 'vip'")->num_rows;
                if($strs->num_rows > 0) {
                    $row = $mysqli->assoc($strs);
                    $str_res = "<div class='strategies-full-box-vip'><div id='strategies-list-vip'>";
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
                        $str_res .= "<div id='load-more-vip'>".$wrap_load->show()."</div>";
                    }
                    $str_res .= "</div>";
                }
                else {
                    $str_res = new Reader("default");
                    $str_res->view("cabinet/infobox");
                    $str_res->change("text", "Список стратегий в данный момент пуст");
                    $str_res = $str_res->show();
                }
                if($user['time_vip'] <= 0 ) {
                    $str_res = new Reader("default");
                    $str_res->view("cabinet/infobox");
                    $str_res->change("text", "Ваше время для vip кабинета истекло | <a href='".URI."/buy/'>купить доступ здесь</a>");
                    $str_res = $str_res->show();
                }
                /* VIDEOS */
                $videos = "";
                $limit = 4;
                $vids = $mysqli->query("SELECT `status`, `title`, `id`, `url`, `likes`, `user_id` FROM `videos` WHERE `status` = '1' ORDER BY `id` DESC LIMIT {$limit}");
                $am = $mysqli->query("SELECT `status`, `title`, `id`, `url`, `likes`, `user_id` FROM `videos` WHERE `status` = '1' ")->num_rows;
                if($vids->num_rows > 0) {
                    $row = $mysqli->assoc($vids);
                    $videos = "<div class='video-full-box'><div id='videos-list'>";
                    do {
                        $title = $row['title'];
                        if(strlen($title) > 45) {
                            $title = mb_substr($title, 0, 45, "UTF-8").'...';
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
                if( $user['timeleft'] <= 0 && $user['time_vip'] <= 0 ) {
                    $videos = new Reader("default");
                    $videos->view("cabinet/infobox");
                    $videos->change("text", "Ваше время для vip кабинета истекло | <a href='".URI."/buy/'>купить доступ здесь</a>");
                    $videos = $videos->show();
                }

                $data->change("videos", $videos);
                $data->change("strategies", $str_cabinet);
                $data->change("strategies_vip", $str_res);
                echo $data->show();
            }
            else {
                if($user['time_vip'] <= 0) {
                    $lock = new Reader("default");
                    $lock->view("cabinet/lock");
                    $lock->change("uri", URI);
                    echo $lock->show();
                }
                elseif(date("l") == "Saturday" ||  date("l") == "Sunday") {
                    $output = new Reader("default");
                    $output->view("cabinet/output");
                    echo $output->show();
                }
                else {
                    $confirm = new Reader("default");
                    $confirm->view("cabinet/confirm");
                    $confirm->change("uri", URI);
                    echo $confirm->show();
                }
            }
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>