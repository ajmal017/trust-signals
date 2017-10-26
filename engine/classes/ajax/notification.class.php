<?php
class Notification extends Core {
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
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            if(isset($_FILES['img']) && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                $img = $_FILES['img'];
                if($img['size'] < 1024*1024*0.2) {
                	if(is_uploaded_file($img['tmp_name'])) {
                		$type = str_replace("image/", "", $img['type']);
                    if($type == 'jpeg' || $type == 'jpg' || $type == 'png') {
                        $name = $adds->uniqName();
                        $path = URI."/engine/templates/default/img/strategies/{$name}.{$type}";
                        move_uploaded_file($img['tmp_name'], "engine/templates/default/img/strategies/{$name}.{$type}");
                        $mysqli->query("UPDATE `strategies` SET `img` = '{$path}' WHERE `id` = '{$id}'");
                        echo $path;
                    }
                    else {
                        echo 'types';
                    }
                	}
                	else {
                		echo "types";
                	}
                }
                else {
                    echo "size";
                }
            }
            elseif(isset($_FILES['add-strategy']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $img = $_FILES['add-strategy'];
                if($img['size'] < 1024*1024*0.5) {
                    $type = str_replace("image/", "", $img['type']);
                    if(($type == 'jpeg' || $type == 'jpg' || $type == 'png') && is_uploaded_file($img['tmp_name'])) {
                        $name = $adds->uniqName();
                        $path = URI."/engine/templates/default/img/strategies/{$name}.{$type}";
                        move_uploaded_file($img['tmp_name'], "engine/templates/default/img/strategies/{$name}.{$type}");
                        echo $path;
                    }
                    else {
                        echo 'types';
                    }
                }
                else {
                    echo "size";
                }
            }
            if(isset($_FILES['img-news']) && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                $img = $_FILES['img-news'];
                if($img['size'] < 1024*1024*0.5) {
                    $type = str_replace("image/", "", $img['type']);
                    if(($type == 'jpeg' || $type == 'jpg' || $type == 'png') && is_uploaded_file($img['tmp_name'])) {
                        $name = $adds->uniqName();
                        $path = URI."/engine/templates/default/img/strategies/{$name}.{$type}";
                        move_uploaded_file($img['tmp_name'], "engine/templates/default/img/strategies/{$name}.{$type}");
                        $mysqli->query("UPDATE `home_news` SET `img` = '{$path}' WHERE `id` = '{$id}'");
                        echo $path;
                    }
                    else {
                        echo 'types';
                    }
                }
                else {
                    echo "size";
                }
            }
            elseif(isset($_FILES['add-news']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $img = $_FILES['add-news'];
                if($img['size'] < 1024*1024*0.5) {
                    $type = str_replace("image/", "", $img['type']);
                    if(($type == 'jpeg' || $type == 'jpg' || $type == 'png') && is_uploaded_file($img['tmp_name'])) {
                        $name = $adds->uniqName();
                        $path = URI."/engine/templates/default/img/strategies/{$name}.{$type}";
                        move_uploaded_file($img['tmp_name'], "engine/templates/default/img/strategies/{$name}.{$type}");
                        echo $path;
                    }
                    else {
                        echo 'types';
                    }
                }
                else {
                    echo "size";
                }
            }
            elseif($action == "add-news-full" && isset($_POST['id']) && isset($_POST['text']) && isset($_POST['title']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $text = stripslashes($_POST['text']);
                $title = $adds->siftText($_POST['title']);
                $id = $adds->siftText($_POST['id']);
                if(!empty($text) && !empty($title)) {
                    $mysqli->query("INSERT INTO `home_news` (`title`, `text`, `img`, `date`, `type`) VALUES ('{$title}', '{$text}', '{$id}', '{$date}', 'cabinet')");
                    $key = $mysqli->query("SELECT `id`, `img` FROM `home_news` WHERE `img` = '{$id}' ORDER BY `id` DESC LIMIT 1");
                    if($key->num_rows == 1) {
                        $key = $mysqli->assoc($key);
                        echo URI."/news_{$key['id']}/";
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "add-strategy-full" && isset($_POST['id']) && isset($_POST['text']) && isset($_POST['type']) && isset($_POST['title']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $text = stripslashes($_POST['text']);
                $title = $adds->siftText($_POST['title']);
                $id = $adds->siftText($_POST['id']);
                $type = $adds->siftText($_POST['type']);
                if($type != 'vip') {
                    $type = 'cabinet';
                }
                if(!empty($text) && !empty($title)) {
                    $mysqli->query("INSERT INTO `strategies` (`title`, `text`, `img`, `date`, `type`) VALUES ('{$title}', '{$text}', '{$id}', '{$date}', '{$type}')");
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-supp") {
                $mysqli->query("DELETE FROM `support` WHERE `user_id` = '{$user['id']}'");
                echo 'success';
            }
            elseif($action == "load-supps") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $num = $adds->toInteger($_POST['n']);
                    $message = $mysqli->query("SELECT * FROM `support` WHERE `email` = '{$user['email']}' AND `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$num}, 5");
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
                                $f->change("img", URI."/engine/templates/default/img/author.jpg");
                            }
                            else {
                                $f->change("pos", "out");
                                $f->change("img", $u_img);
                            }
                            $m_res .= $f->show();
                        }
                        while($mess = $mysqli->assoc($message));
                        echo $m_res;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "load-notifications") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $num = $adds->toInteger($_POST['n']);
                    $get = $mysqli->query("SELECT * FROM `alerts` WHERE `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT {$num}, 10");
                    if($get->num_rows > 0) {
                        $mess = $mysqli->assoc($get);
                        do {
                            $data = new Reader("default");
                            $data->view("mails/notification");
                            $data->change("date", $mess['date']);
                            $data->change("id", $mess['id']);
                            $data->change("message", $mess['text']);
                            $data->change("pos", $mess['icon']);
                            $messages .= $data->show();
                        }
                        while($mess = $mysqli->assoc($get));
                        echo $messages;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "load-news") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $num = $adds->toInteger($_POST['n']);
                    $get = $mysqli->query("SELECT * FROM `home_news` ORDER BY `id` DESC LIMIT {$num}, 10");
                    if($get->num_rows > 0) {
                        $mess = $mysqli->assoc($get);
                        do {
                            $moder = "";
                            $ok = "<a class='edit-str' href='".URI."/ednews_{$mess['id']}/"."' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Редактировать'><span class='glyphicon glyphicon-pencil'></span></a>";
                            if($user['group'] == 'admin' || $user['group'] == 'moder') {
                                $moder = "{$ok} <a class='remove-news' href='#' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                            }
                            $desc = strip_tags($mess['text']);
                            if(mb_strlen($desc) > 350) {
                                $desc = mb_substr($desc, 0, 350).'...';
                            }
                            $tmp = new Reader("default");
                            $tmp->view("ospage/articles");
                            $tmp->change("title", $mess['title']);
                            $tmp->change("description", $desc);
                            $tmp->change("id", $mess['id']);
                            $tmp->change("date", $mess['date']);
                            $tmp->change("img", $mess['img']);
                            $tmp->change("uri", URI);
                            $tmp->change("moder", $moder);
                            $messages .= $tmp->show();
                        }
                        while($mess = $mysqli->assoc($get));
                        echo $messages;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "load-strategies") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $sql_string = "WHERE `type` = 'cabinet'";
                    if(isset($_POST['type'])) { $sql_string = "WHERE `type` = 'vip'"; }
                    $num = $adds->toInteger($_POST['n']);
                    $get = $mysqli->query("SELECT * FROM `strategies` {$sql_string} ORDER BY `id` DESC LIMIT {$num}, 10");
                    if($get->num_rows > 0) {
                        $mess = $mysqli->assoc($get);
                        do {
                            $moder = "";
                            $ok = "<a class='edit-str' href='".URI."/strs_{$mess['id']}/"."' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Редактировать'><span class='glyphicon glyphicon-pencil'></span></a>";
                            if($user['group'] == 'admin' || $user['group'] == 'moder') {
                                $moder = "{$ok} <a class='remove-str' href='#' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                            }
                            $desc = strip_tags($mess['text']);
                            if(strlen($desc) > 400) {
                                $desc = substr($desc, 0, 400).'...';
                            }
                            $tmp = new Reader("default");
                            $tmp->view("pages/str_list");
                            $tmp->change("title", $mess['title']);
                            $tmp->change("description", $desc);
                            $tmp->change("id", $mess['id']);
                            $tmp->change("img", $mess['img']);
                            $tmp->change("URI", URI);
                            $tmp->change("moder", $moder);
                            $messages .= $tmp->show();
                        }
                        while($mess = $mysqli->assoc($get));
                        echo $messages;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == 'set-vote' && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                $exist = $mysqli->query("SELECT `user_id`, `video_id` FROM `videos_points` WHERE `user_id` = '{$user['id']}' AND `video_id` = '{$id}'")->num_rows;
                if(!$exist) {
                    $mysqli->query("UPDATE `videos` SET `likes` = `likes` + 1 WHERE `id` = '{$id}'");
                    $mysqli->query("INSERT INTO `videos_points` (`video_id`, `user_id`) VALUES ('{$id}', '{$user['id']}')");
                    echo 'success';
                }
                else {
                    echo "was";
                }
            }
            elseif($action == "remove-str" && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                if(!empty($id)) {
                    $mysqli->query("DELETE FROM `strategies` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "remove-news" && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                if(!empty($id)) {
                    $mysqli->query("DELETE FROM `home_news` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "news-edit" && isset($_POST['text']) && isset($_POST['title']) && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                $title = $adds->siftText($_POST['title']);
                $text = stripslashes($_POST['text']);
                if(!empty($id) && !empty($title) && !empty($text)) {
                    $mysqli->query("UPDATE `home_news` SET `title` = '{$title}', `text` = '{$text}', `date` = '{$date}' WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "strategy-edit" && isset($_POST['text']) && isset($_POST['title']) && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                $title = $adds->siftText($_POST['title']);
                $text = stripslashes($_POST['text']);
                if(!empty($id) && !empty($title) && !empty($text)) {
                    $mysqli->query("UPDATE `strategies` SET `title` = '{$title}', `text` = '{$text}', `date` = '{$date}' WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-video" && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                if(!empty($id)) {
                    $mysqli->query("DELETE FROM `videos` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "ok-video" && isset($_POST['id']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $id = $adds->toInteger($_POST['id']);
                if(!empty($id)) {
                    $mysqli->query("UPDATE `videos` SET `status` = '1' WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "a-add-video" && isset($_POST['name']) && isset($_POST['url']) && ($user['group'] == 'admin' || $user['group'] == 'moder')) {
                $name = $adds->siftText($_POST['name']);
                $url = $adds->siftText($_POST['url']);
                if(!empty($name) && !empty($url)) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $id);
                    if(isset($id['v'])) {
                        $mysqli->query("INSERT INTO `videos` (`title`, `url`, `user_id`, `likes`, `status`) VALUES ('{$name}', '{$id['v']}', '{$user['id']}', '0', '1')");
                        echo 'success';
                    }
                    else {
                        echo 'url';
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "add-video" && isset($_POST['name']) && isset($_POST['url'])) {
                $name = $adds->siftText($_POST['name']);
                $url = $adds->siftText($_POST['url']);
                if(!empty($name) && !empty($url)) {
                    parse_str(parse_url($url, PHP_URL_QUERY), $id);
                    if(isset($id['v'])) {
                        $mysqli->query("INSERT INTO `videos` (`title`, `url`, `user_id`, `likes`, `status`) VALUES ('{$name}', '{$id['v']}', '{$user['id']}', '0', '0')");
                        echo 'success';
                    }
                    else {
                        echo 'url';
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "load-videos") {
                if(isset($_POST['n'])) {
                    $messages = "";
                    $num = $adds->toInteger($_POST['n']);
                    $s_method = "ORDER BY `id` DESC";
                    if(isset($_POST['sort'])) {
                        $sort = $adds->toInteger($_POST['sort']);
                        if($sort == 2) {
                            $s_method = "ORDER BY `id` ASC";
                        }
                        elseif($sort == 3) {
                            $s_method = "ORDER BY `likes` DESC";
                        }
                    }
                    $get = $mysqli->query("SELECT `status`, `title`, `id`, `url`, `likes`, `user_id` FROM `videos` WHERE `status` = '1' {$s_method} LIMIT {$num}, 4");
                    if($get->num_rows > 0) {
                        $mess = $mysqli->assoc($get);
                        do {
                            $title = $mess['title'];
                            if(strlen($title) > 45) {
                                $title = substr($title, 0, 45).'...';
                            }
                            $name = $mysqli->query("SELECT `name`, `id` FROM `users` WHERE `id` = '{$mess['user_id']}' LIMIT 1");
                            if($name->num_rows) {
                                $name = $mysqli->assoc($name);
                                $name = $name['name'];
                            }
                            else {
                                $name = "Анонимно";
                            }
                            $moder = "";
                            $ok = "<a class='ok-video' href='#' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Утвердить'><span class='glyphicon glyphicon-ok'></span></a>";
                            if($user['group'] == 'admin' || $user['group'] == 'moder') {
                                if($mess['status'] == '1') { $ok = ""; }
                                $moder = "{$ok} <a class='remove-video' href='#' data-id='".$mess['id']."' data-toggle='tooltip' data-placement='top' data-title='Удалить'><span class='glyphicon glyphicon-remove'></span></a>";
                            }
                            $tmp = new Reader("default");
                            $tmp->view("pages/video");
                            $tmp->change("title", $title);
                            $tmp->change("name", $name);
                            $tmp->change("link", $mess['url']);
                            $tmp->change("id", $mess['id']);
                            $tmp->change("votes", $mess['likes']);
                            $tmp->change("URI", URI);
                            $tmp->change("moder", $moder);
                            $messages .= $tmp->show();
                        }
                        while($mess = $mysqli->assoc($get));
                        echo $messages;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == 'update-notification') {
                $am = $mysqli->query("SELECT COUNT(*) AS `count` FROM `alerts` WHERE `user_id` = '{$user['id']}' AND `status` = '1'");
                $amount = $mysqli->assoc($am);
                $amount = $amount['count'];
                echo $amount;
            }
        }
        else {
            echo "auth";
        }
    }
}
?>