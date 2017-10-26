<?php
class Supp extends Core {
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
        if($adds->isAuth() && ( $user['group'] == 'admin' || $user['group'] == 'moder') ) {
            if($action == "send-message" && isset($_POST['email']) && isset($_POST['id']) && isset($_POST['text'])) {
                $text = $adds->siftText($_POST['text']);
                $email = $adds->siftText($_POST['email']);
                $id = $adds->toInteger($_POST['id']);
                $date_time = date("Y-m-d H:i:s");
                if(!empty($text)) {
                    if($id == 0) {
                        $mess = "<p>Здравствуйте.</p>
                                 <p>{$text}</p>";
                        $adds->sendMail($email, "Служба поддержки -  trust-signals.com", $mess);
                    }
                    else {
                        $mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`) VALUES ('{$id}', '{$text}', '{$date}', '0')");
                    }
                    $mysqli->query("INSERT INTO `support` (`text`, `subject`, `user_id`, `email`, `type`, `date`, `status`) VALUES ('{$text}', 'Ответ', '{$id}', '{$email}', '1', '{$date_time}', '1')");
                    $res = new Reader("default");
                    $res->view("admin/supp_dialog_rec");
                    $res->change("img", $user['img']);
                    $res->change("subject", "Ответ");
                    $res->change("text", $text);
                    $res->change("pos", "out");
                    $res->change("date", $date_time);
                    echo $res->show();
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-supp-full") {
                $mysqli->query("DELETE FROM `support`");
                echo 'success';
            }
            elseif($action == "send-message-post" && isset($_POST['email']) && isset($_POST['text'])) {
                $text = $adds->siftText($_POST['text']);
                $email = $_POST['email'];
                if(!empty($text)) {
                    $n_sql = $mysqli->query("SELECT `name`, `email` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                    if($n_sql->num_rows == 1) {
                        $n_sql = $mysqli->assoc($n_sql);
                        $name = $n_sql['name'];
                        $name = explode(" ", $name);
                        $name = $name[0];

                        $mess = new Reader("default");
                        $mess->view("patterns/template");
                        $mess->change("name", $name);
                        $mess->change("message", $text);
                        $mess = $mess->show();

                        $adds->sendMail($email, "Администрация -  trust-signals.com", $mess);
                        echo "success";
                    }
                    else {
                        echo 'empty';
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "add-link" && isset($_POST['link']) && isset($_POST['description'])) {
                $link = $adds->siftText($_POST['link']);
                $description = $adds->siftText($_POST['description']);
                if(!empty($link) && !empty($description)) {
                    $mysqli->query("INSERT INTO `links` (`link`, `description`, `views`) VALUES ('{$link}', '{$description}', '0')");
                    $last = $mysqli->query("SELECT * FROM `links` WHERE `link` = '{$link}' AND `description` = '{$description}' ORDER BY `id` DESC LIMIT 1");
                    if($last->num_rows == 1) {
                        $f = $mysqli->assoc($last);
                        $inf = new Reader("default");
                        $inf->view("admin/link");
                        $inf->change("id", $f['id']);
                        $inf->change("link", $f['link']);
                        $inf->change("description", $f['description']);
                        $inf->change("views", $f['views']);
                        $inf->change("URI", URI);
                        echo $inf->show();
                    }
                    else {
                        echo "error";
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "posts-message" && isset($_POST['text'])) {
                $text = $adds->siftText($_POST['text']);
                if(!empty($text)) {
                    $users_data = $mysqli->query("SELECT `id`, `name` FROM `users`");
                    if($users_data->num_rows > 0) {
                        $users_d = $mysqli->assoc($users_data);
                        do {
                            $id = $users_d['id'];
                            $name = explode(" ", $users_d['name']);
                            $name = $name[0];
                            $text_tmp = "Здравствуйте, {$name}.<br /> {$text}";
                            $mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`) VALUES ('{$id}', '{$text_tmp}', '{$date}', '0')");
                        }
                        while($users_d = $mysqli->assoc($users_data));
                    }
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-link" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `links` WHERE `id` = '{$id}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "remove-supp" && isset($_POST['id']) && isset($_POST['email'])) {
                $id = $adds->toInteger($_POST['id']);
                $email = $adds->siftText($_POST['email']);
                $mysqli->query("DELETE FROM `support` WHERE `user_id` = '{$id}' AND `email` = '{$email}'");
                echo 'success';
            }
            else {
                exit("action error");
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>