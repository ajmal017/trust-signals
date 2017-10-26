<?php
class Profile extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            if(isset($_FILES['img'])) {
                $img = $_FILES['img'];
                if($img['size'] < 1024*1024*0.2) {
                    $type = str_replace("image/", "", $img['type']);
                    if($type == 'jpeg' || $type == 'jpg' || $type == 'png') {
                    	if(is_uploaded_file($img['tmp_name'])) {
                        $name = $adds->uniqName();
                        $path = URI."/engine/templates/default/img/users/{$name}.{$type}";
                        move_uploaded_file($img['tmp_name'], "engine/templates/default/img/users/{$name}.{$type}");
                        $mysqli->query("UPDATE `users` SET `img` = '{$path}' WHERE `id` = '{$user['id']}'");
                        echo $path;
                      }
                      else {
                      	echo "types";
                      }
                    }
                    else {
                        echo 'types';
                    }
                }
                else {
                    echo "size";
                }
            }
            elseif($action == "change-name") {
                if(isset($_POST['name'])) {
                    $name = $adds->siftText($_POST['name']);
                    if(!empty($name)) {
                        $is_check_email = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'open_email' AND `value` = '1' LIMIT 1");
                        if($is_check_email->num_rows == 1 && isset($_POST['email'])) {
                            $email = $adds->siftText($_POST['email']);
                            if(preg_match("/^([\w\.]+)@{1}(\w+)\.([\w\.]){2,6}$/", $email)) {
                                $mysqli->query("UPDATE `users` SET `email` = '{$email}' WHERE `id` = '{$user['id']}'");
                            }
                            else {
                                exit("email");
                            }
                        }
                        $mysqli->query("UPDATE `users` SET `name` = '{$name}' WHERE `id` = '{$user['id']}'");
                        echo 'success';
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "change-soc") {
                if(isset($_POST['name'])) {
                    $name = $adds->siftText($_POST['name']);
                    if(!empty($name)) {
                        if(preg_match("/^http:\/\/([\w\-\_\d]+)\.([\w\-\_\d]{2,5}(.*))$/", $name)) {
                            $mysqli->query("UPDATE `users` SET `soc_url` = '{$name}' WHERE `id` = '{$user['id']}'");
                            echo 'success';
                        }
                        else {
                            echo "format";
                        }
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "change-pass") {
                if(isset($_POST['password']) && isset($_POST['repeatPass'])) {
                    $pass = $_POST['password'];
                    $repeat = $_POST['repeatPass'];
                    if(!empty($pass)) {
                        if($pass == $repeat) {
                            if(strlen($pass) > 7) {
                                $pass = md5($pass);
                                $mysqli->query("UPDATE `users` SET `password` = '{$pass}' WHERE `id` = '{$user['id']}'");
                                echo 'success';
                            }
                            else {
                                echo "easy";
                            }
                        }
                        else {
                            echo "equalize";
                        }
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
            elseif($action == "add-match-to-list") {
                if(isset($_POST['match'])) {
                    $match = $adds->siftText($_POST['match']);
                    $m_r = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
                    $m2_r = $mysqli->query("SELECT `translate` FROM `quotes_list` WHERE `translate` = '{$match}' LIMIT 1");
                    if($m_r->num_rows == 0 && $m2_r->num_rows == 1) {
                        $mysqli->query("INSERT INTO `users_quotes` (`translate_name`, `user_id`) VALUES ('{$match}', '{$user['id']}')");
                        echo "success";
                    }
                }
            }
            elseif($action == "remove-match-to-list") {
                if(isset($_POST['match'])) {
                    $match = $adds->siftText($_POST['match']);
                    $m_r = $mysqli->query("SELECT `translate_name`, `user_id` FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
                    $m2_r = $mysqli->query("SELECT `translate` FROM `quotes_list` WHERE `translate` = '{$match}' LIMIT 1");
                    if($m_r->num_rows > 0 && $m2_r->num_rows == 1) {
                        $mysqli->query("DELETE FROM `users_quotes` WHERE `translate_name` = '{$match}' AND `user_id` = '{$user['id']}'");
                        echo "success";
                    }
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>