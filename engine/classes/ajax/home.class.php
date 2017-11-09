<?php
class Home extends Core {
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
        if($action == "auth") {
            if(isset($_POST['email']) && isset($_POST['password'])) {
                $email = $adds->siftText($_POST['email']);
                $password = md5($_POST['password']);
                $auth = $mysqli->query("SELECT `email`, `password`, `id`, `lasttime` FROM `users` WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1");
                if($auth->num_rows == 1) {
                    $data = $mysqli->assoc($auth);
                    $_SESSION['user'] = $data['id'];




                    if($adds->toInteger($data['lasttime']) > 0) {
                        $mysqli->query("UPDATE `users` SET `lasttime_15` = '30', `lasttime_30` = '30' WHERE `id` = '{$data['id']}'");
                    }
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            else {
                echo 'error';
            }
        }
        elseif($action == "change-email") {
            if(isset($_POST['id']) && isset($_POST['email'])) {
                $id = $adds->toInteger($_POST['id']);
                $email = $adds->siftText($_POST['email']);
                $result = $mysqli->query("SELECT `email` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                if($result->num_rows == 0) {
                    if(preg_match("/^([\w\.\-\_\d]+)\@([\w\-\_\.\d]+)\.([\w]{2,6})$/", $email)) {
                        $exist = $mysqli->query("SELECT `id`, `word`, `email`, `name` FROM `users` WHERE `id` = '{$id}' LIMIT 1");
                        if($exist->num_rows == 1) {
                            $ud = $mysqli->assoc($exist);
                            $pass = uniqid();
                            $pass_md5 = md5($pass);
                            $mysqli->query("UPDATE `users` SET `email` = '{$email}', `password` = '{$pass_md5}' WHERE `id` = '{$id}'");
                            $_SESSION['user'] = $id;
                            $name = explode(" ", $ud['name']);
                            $name = $name[0];
                            $word = $ud['word'];
                            $mail_md5 = md5($email);
                            $mess = "";
                            $m_box = new Reader("default");
                            $m_box->view("patterns/register");
                            $m_box->change("email", $email);
                            $m_box->change("name", $name);
                            $m_box->change("link", URI."/activate/{$mail_md5}/");
                            $mess = $m_box->show();
                            $adds->sendMail($email, "Регистрация -  trust-signals.com", $mess);
                            echo 'success';
                        }
                        else {
                            echo 'error';
                        }
                    }
                    else {
                        echo 'format';
                    }
                }
                else {
                    echo 'exists';
                }
            }
            else {
                echo 'data';
            }
        }
        elseif($action == "send") {
            if(isset($_POST['subject']) && isset($_POST['text']) && isset($_POST['email']) && isset($_POST['name'])) {
                $email = $_POST['email'];
                $name = $adds->siftText($_POST['name']);
                $subject = $adds->siftText($_POST['subject']);
                $text = $adds->siftText($_POST['text']);
                if(!empty($text) && !empty($subject) && !empty($name)) {
                    if(preg_match("/^([\w\.\-\_\d]+)\@([\w\-\_\.\d]+)\.([\w]{2,6})$/", $email)) {
                        $date = date("Y-m-d");
                        $mess = "";
                        $mess .= "<p>Имя:<br /><strong>{$name}</strong><p>";
                        $mess .= "<p>E-mail:<br /><strong>{$email}</strong><p>";
                        $mess .= "<p>Тема:<br /><strong>{$subject}</strong><p>";
                        $mess .= "<p>Сообщение:<br /><strong>{$text}</strong><p>";
                        $adds->sendMail("support@trust-signals.com", 'Техподдержка - ' . $subject, $mess);
                        // support@trust-signals.com
                        // $mysqli->query("INSERT INTO `support` (`text`, `subject`, `user_id`, `name`, `email`, `from`) VALUES ('{$text}', '{$subject}', '0', '{$name}', '{$email}', 'home')");
                        echo "success";
                    }
                    else {
                        echo 'format';
                    }
                }
                else {
                    echo 'empty';
                }
            }
            else {
                echo 'data';
            }
        }
        elseif($action == 'reg') {
            if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-repeat']) && isset($_POST['name']) && isset($_POST['sex']) && isset($_POST['word'])) {
                $email = $adds->siftText($_POST['email']);
                $pass_tmp = $adds->siftText($_POST['password']);
                $password = md5($_POST['password']);
                $password_repeat = md5($_POST['password-repeat']);
                $name = $adds->siftText($_POST['name']);
                $sex = $adds->toInteger($_POST['sex']);
                $word = $adds->siftText($_POST['word']);
                $type = $_POST['type'];
                if(!empty($word) && !empty($name)) {
                    if(strlen($pass_tmp) > 7) {
                        if($password == $password_repeat) {
                            if(preg_match("/^([\w\.\-\_]+)\@([\w\-\_\.]+)\.([\w]{2,6})$/", $email)) {
                                if($sex == 1) {
                                    $sex = 1;
                                }
                                else {
                                    $sex = 0;
                                }
                                $result = $mysqli->query("SELECT `email` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                                if($result->num_rows == 0) {
                                    $date = date("Y-m-d");
                                    $start_time = 0;
                                    $st_sql = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'demo'");
                                    if($st_sql->num_rows == 1) {
                                        $st_sql = $st_sql->fetch_assoc();
                                        $st_sql = $st_sql['value'];
                                        if($st_sql == 1) {
                                            $start_time = 30;
                                            $s_time_get = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'a_time' LIMIT 1");
                                            if($s_time_get->num_rows == 1) {
                                                $s_time_get = $mysqli->assoc($s_time_get);
                                                $start_time = $adds->toInteger($s_time_get['value']);
                                            }
                                        }
                                    }
                                    $web_start_time = 0;
                                    $st_sql = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_demo'");
                                    if($st_sql->num_rows == 1) {
                                        $st_sql = $st_sql->fetch_assoc();
                                        $st_sql = $st_sql['value'];
                                        if($st_sql == 1) {
                                            $web_start_time = 30;
                                            $s_time_get = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'web_time' LIMIT 1");
                                            if($s_time_get->num_rows == 1) {
                                                $s_time_get = $mysqli->assoc($s_time_get);
                                                $web_start_time = $adds->toInteger($s_time_get['value']);
                                            }
                                        }
                                    }
                                    $date_full = date("Y-m-d H:i:s");
                                    $mysqli->query("INSERT INTO `users` (`email`, `password`, `timeleft`, `name`, `time_vip`, `sex`, `date`, `word`, `web_lasttime`) VALUES ('{$email}', '{$password}', '{$start_time}', '{$name}', 0, '{$sex}', '{$date_full}', '{$word}', '{$web_start_time}')");
                                    $spk = $mysqli->query("SELECT `id`, `email` FROM `users` WHERE `email` = '{$email}'");
                                    $spk = $spk->fetch_assoc();
                                    $spk = $spk["id"];

                                    if(isset($_SESSION['aff_id'])) {
                                        $id_aff = $_SESSION['aff_id'];
                                        $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND `user` = '{$id_aff}'");
                                        if($isset_day->num_rows > 0) {
                                            $mysqli->query("UPDATE `history` SET `count_reg` = `count_reg` + 1 WHERE `date` = '{$date}' AND `user` = '{$id_aff}'");
                                        }
                                        else {
                                            $mysqli->query("INSERT INTO `history` (`date`, `user`, `count_reg`) VALUES ('{$date}', '{$id_aff}', '1')");
                                        }
                                        $mysqli->query("INSERT INTO `aff_list` (`spk_id`, `aff_id`) VALUES ('{$spk}', '{$id_aff}')");
                                        $mysqli->query("UPDATE `aff_list` SET `count_reg` = `count_reg` + 1 WHERE `aff_id` = '{$id_aff}'");
                                    }

                                    if($adds->isDaily()) {
                                        $mysqli->query("UPDATE `statistic` SET `count_reg` = `count_reg` + 1 WHERE `date` = '{$date}'");
                                    }
                                    else {
                                        $mysqli->query("INSERT INTO `statistic` (`date`, `count_reg`, `pays`,`prefit`, `views`) VALUES ('{$date}', '1', '0', '0', '0')");
                                    }
                                    $_SESSION['user'] = $spk;
                                    $mail_md5 = md5($email);
                                    $name = explode(" ", $name);
                                    $name = $name[0];
                                    $mess = "";
                                    $m_box = new Reader("default");
                                    $m_box->view("patterns/register");
                                    $m_box->change("email", $email);
                                    $m_box->change("name", $name);
                                    $m_box->change("link", URI."/activate/{$mail_md5}/");
                                    $mess = $m_box->show();

                                    if(!$type) $adds->sendMail($email, "Регистрация -  trust-signals.com", $mess);
                                    echo "success";
                                }
                                else {
                                    echo "email2";
                                }
                            }
                            else {
                                echo "email";
                            }
                        }
                        else {
                            echo "pass1";
                        }
                    }
                    else {
                        echo "pass2";
                    }
                }
                else {
                    echo "data";
                }
            }
            else {
                echo "data";
            }
        }
        elseif($action == 'recovery') {
            if(isset($_POST['email']) && isset($_POST['word'])) {
                $email = $adds->siftText($_POST['email']);
                $word = $adds->siftText($_POST['word']);
                $exist = $mysqli->query("SELECT `email`, `word`, `name` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                if($exist->num_rows == 1) {
                    $name = $mysqli->assoc($exist);
                    $name = explode(" ", $name['name']);
                    $name = $name[0];
                    $pass = mb_substr(uniqid(), 0, 6);
                    $pass_md5 = md5($pass);
                    $mess = "";
                    $m_box = new Reader("default");
                    $m_box->view("patterns/recovery");
                    $m_box->change("password", $pass);
                    $m_box->change("name", $name);
                    $m_box->change("email", $email);
                    $mess = $m_box->show();
                    if(!$adds->sendMail($email, "Восстановление пароля trust-signals.com", $mess)) {
                        exit('not-mail');
                    }
                    $mysqli->query("UPDATE `users` SET `password` = '{$pass_md5}' WHERE `email` = '{$email}'");
                    echo 'success';
                }
                else {
                    echo 'error';
                }
            }
            else {
                echo 'data';
            }
        }
    }
}
?>