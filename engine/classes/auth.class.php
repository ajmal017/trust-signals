<?php
class Auth extends Core {
    public function getTitle() {
        echo "Социальные сети";

    }
    public function getContent() {
        $date = date("Y-m-d");
        $this->changeLauncher("auth");
        $adds = new Additions();
        if(!$adds->isAuth()) {
            global $mysqli;
            $this->templateEdit("description", "Авторизация через социальные сети. Вы можете без забот создать новый аккаунт всего в пару кликов");
            $code = $_SERVER['REQUEST_URI'];
            $code = substr($code, strpos($code, "?"), strlen($code));
            $code = str_replace("?", "", $code);
            $code = explode("&", $code);
            for($i = 0; $i < count($code); $i++) {
                $arr = explode("=", $code[$i]);
                $_GET[$arr[0]] = "";
                if(isset($arr[1])) {
                    $_GET[$arr[0]] = $arr[1];
                }
            }
            if(isset($_GET['code'])) {
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
                if($_GET['auth'] == 'vk') {
                    if (isset($_GET['code'])) {
                        $result = false;
                        $params = array(
                            'client_id' => VK_CLIENT_ID,
                            'client_secret' => VK_CLIENT_SECRET,
                            'code' => $_GET['code'],
                            'redirect_uri' => VK_REDIRECT
                        );
                        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
                        if (isset($token['access_token'])) {
                            $params = array(
                                'uids'         => $token['user_id'],
                                'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                                'access_token' => $token['access_token']
                            );
                            $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
                            if (isset($userInfo['response'][0]['uid'])) {
                                $userInfo = $userInfo['response'][0];
                                $result = true;
                            }
                        }
                        if($result) {
                            $uid = $userInfo['uid'];
                            $name = $userInfo['first_name'] ." ". $userInfo['last_name'];
                            $img = $userInfo['photo_big'];
                            $soc_url = "http://vk.com/id{$uid}";
                            $sex = 0;
                            if($userInfo['sex'] == '2') {
                                $sex = 1;
                            }
                            $exist = $mysqli->query("SELECT `uid`, `email`, `auth_type`, `id`, `word` FROM `users` WHERE `uid` = '{$uid}' AND `auth_type` = 'vk' LIMIT 1");
                            if($exist->num_rows == 1) {
                                $udata = $mysqli->assoc($exist);
                                if(empty($udata['email'])) {
                                    $cemail = new Reader("default");
                                    $cemail->view("auth/start");
                                    $cemail->change("id", $udata['id']);
                                    echo $cemail->show();
                                }
                                else {
                                    $_SESSION['user'] = $udata['id'];
                                    setcookie("user", $udata['id']);
                                    $adds->redirect(URI."/cabinet/");
                                }
                            }
                            else {
                                $mysqli->query("INSERT INTO `users` (`uid`, `auth_type`, `img`, `soc_url`, `date`, `word`, `name`, `timeleft`, `time_vip`, `sex`) VALUES ('{$uid}', 'vk', '{$img}', '{$soc_url}', '{$date}', '{$name}', '{$name}', '{$start_time}', '0', '{$sex}')");
                                $spk = $mysqli->query("SELECT `uid`, `auth_type`, `id` FROM `users` WHERE `uid` = '{$uid}' AND `auth_type` = 'vk'");
                                $spk = $mysqli->assoc($spk);
                                $spk = $spk["id"];
                                if(isset($_SESSION['aff_id'])) {
                                    $id_aff = $_SESSION['aff_id'];
                                    $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND user = '{$id_aff}'");
                                    if($isset_day->num_rows == 1) {
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
                                $cemail = new Reader("default");
                                $cemail->view("auth/start");
                                $cemail->change("id", $spk);
                                echo $cemail->show();
                            }
                        }
                        else {
                            $adds->redirect(URI."/home/");
                        }
                    }
                }
                elseif($_GET['auth'] == 'ok') {
                    if (isset($_GET['code'])) {
                        $result = false;
                        $params = array(
                            'code' => $_GET['code'],
                            'redirect_uri' => OK_REDIRECT,
                            'grant_type' => 'authorization_code',
                            'client_id' => OK_CLIENT_ID,
                            'client_secret' => OK_CLIENT_SECRET
                        );
                        $url = 'http://api.odnoklassniki.ru/oauth/token.do';
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        $result = curl_exec($curl);
                        curl_close($curl);
                        $tokenInfo = json_decode($result, true);
                        $public_key = OK_CLIENT_PUBLIC;
                        if (isset($tokenInfo['access_token']) && isset($public_key)) {
                            $sign = md5("application_key={$public_key}format=jsonmethod=users.getCurrentUser" . md5("{$tokenInfo['access_token']}".OK_CLIENT_SECRET));
                            $params = array(
                                'method'          => 'users.getCurrentUser',
                                'access_token'    => $tokenInfo['access_token'],
                                'application_key' => $public_key,
                                'format'          => 'json',
                                'sig'             => $sign
                            );
                            $userInfo = json_decode(file_get_contents('http://api.odnoklassniki.ru/fb.do' . '?' . urldecode(http_build_query($params))), true);
                            if (isset($userInfo['uid'])) {
                                $result = true;
                            }
                            if($result) {
                                $uid = $userInfo['uid'];
                                $name = $userInfo['name'];
                                $img = $userInfo['pic_2'];
                                $soc_url = "http://www.odnoklassniki.ru/profile/{$uid}";
                                $sex = 0;
                                if($userInfo['gender'] == 'male') {
                                    $sex = 1;
                                }
                                $exist = $mysqli->query("SELECT `uid`, `email`, `auth_type`, `id`, `word` FROM `users` WHERE `uid` = '{$uid}' AND `auth_type` = 'ok' LIMIT 1");
                                if($exist->num_rows == 1) {
                                    $udata = $mysqli->assoc($exist);
                                    if(empty($udata['email'])) {
                                        $cemail = new Reader("default");
                                        $cemail->view("auth/start");
                                        $cemail->change("id", $udata['id']);
                                        echo $cemail->show();
                                    }
                                    else {
                                        $_SESSION['user'] = $udata['id'];
                                        setcookie("user", $udata['id']);
                                        $adds->redirect(URI."/cabinet/");
                                    }
                                }
                                else {
                                    $mysqli->query("INSERT INTO `users` (`uid`, `auth_type`, `img`, `soc_url`, `date`, `word`, `name`, `timeleft`, `time_vip`, `sex`) VALUES ('{$uid}', 'ok', '{$img}', '{$soc_url}', '{$date}', '{$name}', '{$name}', '{$start_time}', '0', '{$sex}')");
                                    $spk = $mysqli->query("SELECT `uid`, `auth_type`, `id` FROM `users` WHERE `uid` = '{$uid}' AND `auth_type` = 'ok'");
                                    $spk = $mysqli->assoc($spk);
                                    $spk = $spk["id"];
                                    if(isset($_SESSION['aff_id'])) {
                                        $id_aff = $_SESSION['aff_id'];
                                        $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND user = '{$id_aff}'");
                                        if($isset_day->num_rows == 1) {
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
                                    $cemail = new Reader("default");
                                    $cemail->view("auth/start");
                                    $cemail->change("id", $spk);
                                    echo $cemail->show();
                                }
                            }
                            else {
                                $adds->redirect(URI."/home/");
                            }
                        }
                    }
                }
                elseif($_GET['auth'] == 'ya') {
                    if(isset($_GET['code'])) {
                        $res = false;
                        $params = array(
                            'grant_type'    => 'authorization_code',
                            'code'          => $_GET['code'],
                            'client_id'     => YA_CLIENT_ID,
                            'client_secret' => YA_CLIENT_SECRET
                        );
                        $url = 'https://oauth.yandex.ru/token';
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                        $result = curl_exec($curl);
                        curl_close($curl);
                        $tokenInfo = json_decode($result, true);
                        if(isset($tokenInfo['access_token'])) {
                            $params = array(
                                'format'       => 'json',
                                'oauth_token'  => $tokenInfo['access_token']
                            );
                            $userInfo = json_decode(file_get_contents('https://login.yandex.ru/info' . '?' . urldecode(http_build_query($params))), true);
                            if (isset($userInfo['id'])) {
                                $userInfo = $userInfo;
                                $res = true;
                            }
                            if($res) {
                                $uid = $userInfo['id'];
                                $email = $userInfo['default_email'];
                                $name = $userInfo['real_name'];
                                $sex = 0;
                                if($userInfo['sex'] == 'male') {
                                    $sex = 1;
                                }
                                $exist_email = $mysqli->query("SELECT `email`, `id` FROM `users` WHERE `email` = '{$email}' LIMIT 1");
                                if($exist_email->num_rows == 0) {
                                    $pass = uniqid();
                                    $pass_md5 = md5($pass);
                                    $mysqli->query("INSERT INTO `users` (`confirm`, `uid`, `auth_type`, `date`, `word`, `name`, `timeleft`, `time_vip`, `sex`, `email`, `password`) VALUES ('1', '{$uid}', 'ya', '{$date}', '{$name}', '{$name}', '{$start_time}', '0', '{$sex}', '{$email}', '{$pass_md5}')");
                                    $spk = $mysqli->query("SELECT `uid`, `auth_type`, `id` FROM `users` WHERE `uid` = '{$uid}' AND `auth_type` = 'ya'");
                                    $spk = $mysqli->assoc($spk);
                                    $spk = $spk["id"];
                                    if(isset($_SESSION['aff_id'])) {
                                        $id_aff = $_SESSION['aff_id'];
                                        $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND user = '{$id_aff}'");
                                        if($isset_day->num_rows == 1) {
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
                                    $mail_md5 = md5($email);
                                    $mess = "<p>Здравствуйте, {$name}</p>
                                             <p>Вы успешно зарегистрированы на портале trust-signals.com</p>
                                             <p>Ваши данные для авторизации:</p>
                                             <p>Логин: <b>{$email}</b></p>
                                             <p>Пароль: <b>{$pass}</b></p>
                                             <p>Ваше серетное слово: <b>{$name}</b></p>";
                                    $adds->sendMail($email, "Регистрация -  trust-signals.com", $mess);
                                    $_SESSION['user'] = $spk;
									setcookie("user", $spk);
                                    $adds->redirect(URI."/cabinet/");
                                }
                                else {
                                    $uid = $mysqli->assoc($exist_email);
                                    $uid = $uid['id'];
                                    $_SESSION['user'] = $uid;
					setcookie("user", $uid);
                                    $adds->redirect(URI."/home/");
                                }
                            }
                            else {
                                $adds->redirect(URI."/home/");
                            }
                        }
                        else {
                            $adds->redirect(URI."/home/");
                        }
                    }
                    else {
                        $adds->redirect(URI."/home/");
                    }
                }
            }
            else {
                $adds->redirect(URI."/home/");
            }
        }
        else {
            $adds->redirect(URI."/cabinet/");
        }
    }
}
?>