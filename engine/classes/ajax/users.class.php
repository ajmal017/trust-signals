<?php
class Users extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        $user = $adds->getUserData();
        if($adds->isAuth()) {
            if($action == "upload" && $user['timeleft'] > 0 && $user['confirm'] == 1 && date("l") != "Saturday" &&  date("l") != "Sunday") {
                $users = "";
                $exists = $mysqli->query("SELECT * FROM `users_signals` ORDER BY `id` DESC LIMIT 1");
                if($exists->num_rows == 1) {
                    $signal = $mysqli->assoc($exists);
                    $name = "Аноним";
                    $img = URI."/engine/templates/default/img/author.jpg";
                    $rank = 0;
                    $usr = $mysqli->query("SELECT `name`, `img`, `rank` FROM `users` WHERE `id` = '{$signal['user_id']}' LIMIT 1");
                    if($usr->num_rows == 1) {
                        $usr = $mysqli->assoc($usr);
                        if(!empty($usr['img'])) {
                            $img = $usr['img'];
                        }
                        $rank = $usr['rank'];
                        $name = $usr['name'];
                    }
                    $pos = 'down';
                    if($signal['torb'] == 1) {
                        $pos = 'up';
                    }
                    $v_box = "";
                    $votes = $signal['like'] + $signal['dislike'];
                    $interest = $signal['like'] * 100 / $votes;
                    $ready_vote = $mysqli->query("SELECT `signal_id`, `user_id`, `point` FROM `users_points` WHERE `signal_id` = '{$signal['id']}' AND `user_id` = '{$user['id']}' LIMIT 1");
                    if($ready_vote->num_rows == 1) {
                        $vi = $mysqli->assoc($ready_vote);
                        $message = "Подтверждение";
                        if($vi['point'] == 0) {
                            $message = "Отрицание";
                        }
                        $vb = new Reader("default");
                        $vb->view("cabinet/ready_votes");
                        $vb->change("message", $message);
                        $vb->change("type", $vi['point']);
                        $v_box = $vb->show();
                    }
                    else {
                        $vb = new Reader("default");
                        $vb->view("cabinet/votes");;
                        $vb->change("amount", $votes);
                        $v_box = $vb->show();
                    }
                    $sg = new Reader("default");
                    $sg->view("cabinet/user");
                    $sg->change("photo", $img);
                    $sg->change("name", $name);
                    $sg->change("rank", $rank);
                    $sg->change("symbol", $signal['symbol']);
                    $sg->change("time_exp", $signal['exp_time']);
                    $sg->change("time", $signal['time']);
                    $sg->change("date", $signal['date']);
                    $sg->change("id", $signal['id']);
                    $sg->change("pos", $pos);
                    $sg->change("interest", $interest);
                    $sg->change("votes", $v_box);
                    echo $sg->show();
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "get-time") {
                echo date("H:i");
            }
            elseif($action == "vote") {
                if(isset($_POST['id']) && isset($_POST['vote'])) {
                    $id = $adds->toInteger($_POST['id']);
                    $vote = $adds->toInteger($_POST['vote']);
                    $users = "";
                    $ready_vote_apply = $mysqli->query("SELECT `signal_id`, `user_id` FROM `users_points` WHERE `user_id` = '{$user['id']}' AND `signal_id` = '{$id}' LIMIT 1");
                    if($ready_vote_apply->num_rows == 0) {
                        if($vote == 0 || $vote == 1) {
                            $mysqli->query("INSERT INTO `users_points` (`user_id`, `signal_id`, `point`) VALUES ('{$user['id']}', '{$id}', '{$vote}')");
                            if($vote == 0) {
                                $mysqli->query("UPDATE `users_signals` SET `dislike` = `dislike` + 1 WHERE `id` = '{$id}'");
                            }
                            else {
                                $mysqli->query("UPDATE `users_signals` SET `like` = `like` + 1 WHERE `id` = '{$id}'");
                            }

                            $exists = $mysqli->query("SELECT * FROM `users_signals` WHERE `id` = '{$id}'  ORDER BY `id` DESC LIMIT 1");
                            if($exists->num_rows == 1) {
                                $signal = $mysqli->assoc($exists);
                                $name = "Аноним";
                                $img = URI."/engine/templates/default/img/author.jpg";
                                $rank = 0;
                                $usr = $mysqli->query("SELECT `name`, `img`, `rank`, `likes` FROM `users` WHERE `id` = '{$signal['user_id']}' LIMIT 1");
                                if($usr->num_rows == 1) {
                                    $usr = $mysqli->assoc($usr);
                                    if(!empty($usr['img'])) {
                                        $img = $usr['img'];
                                    }
                                    $rank = $usr['rank'];
                                    $name = $usr['name'];
                                    if($vote == 1) {
                                        if(($adds->toInteger($usr['likes']) + 1) % 5 == 0) {
                                            $mysqli->query("UPDATE `users` SET `rank` = `rank` + 1 WHERE `id` = '{$signal['user_id']}'");
                                        }
                                        $mysqli->query("UPDATE `users` SET `likes` = `likes` + 1 WHERE `id` = '{$signal['user_id']}'");
                                    }
                                    else {
                                        $mysqli->query("UPDATE `users` SET `dislikes` = `dislikes` + 1 WHERE `id` = '{$signal['user_id']}'");
                                    }

                                }
                                $pos = 'down';
                                if($signal['torb'] == 1) {
                                    $pos = 'up';
                                }
                                $v_box = "";
                                $votes = $signal['like'] + $signal['dislike'];
                                $interest = $signal['like'] * 100 / $votes;
                                $ready_vote = $mysqli->query("SELECT `signal_id`, `user_id`, `point` FROM `users_points` WHERE `signal_id` = '{$signal['id']}' AND `user_id` = '{$user['id']}' LIMIT 1");
                                if($ready_vote->num_rows == 1) {
                                    $vi = $mysqli->assoc($ready_vote);
                                    $message = "Подтверждение";
                                    if($vi['point'] == 0) {
                                        $message = "Отрицание";
                                    }
                                    $vb = new Reader("default");
                                    $vb->view("cabinet/ready_votes");
                                    $vb->change("message", $message);
                                    $vb->change("type", $vi['point']);
                                    $v_box = $vb->show();
                                }
                                else {
                                    $vb = new Reader("default");
                                    $vb->view("cabinet/votes");;
                                    $vb->change("amount", $votes);
                                    $v_box = $vb->show();
                                }
                                $sg = new Reader("default");
                                $sg->view("cabinet/user");
                                $sg->change("photo", $img);
                                $sg->change("name", $name);
                                $sg->change("rank", $rank);
                                $sg->change("symbol", $signal['symbol']);
                                $sg->change("time_exp", $signal['exp_time']);
                                $sg->change("time", $signal['time']);
                                $sg->change("date", $signal['date']);
                                $sg->change("id", $signal['id']);
                                $sg->change("pos", $pos);
                                $sg->change("interest", $interest);
                                $sg->change("votes", $v_box);
                                echo $sg->show();
                            }
                            else {
                                echo 'empty';
                            }
                        }
                        else {
                            echo 'empty';
                        }
                    }
                    else {
                        echo 'empty';
                    }
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == 'add-signal') {
                if(isset($_POST['time']) && isset($_POST['time-exp']) && isset($_POST['symbol']) && isset($_POST['pos'])) {
                    $time = trim($_POST['time']);
                    $time_exp = $adds->toInteger($_POST['time-exp']);
                    $symbol = $adds->siftText($_POST['symbol']);
                    $pos = $adds->toInteger($_POST['pos']);
                    $date = date("Y-m-d");
                    if(empty($time_exp) || empty($time) || empty($symbol)) {
                        exit("empty");
                    }
                    if($pos == 0 || $pos == 1) {
                        if(preg_match("/^\d{2}\:\d{2}$/", $time)) {
                            $lid = $mysqli->query("INSERT INTO `users_signals`
                                                (`time`, `date`, `exp_time`, `symbol`, `torb`, `like`, `user_id`, `dislike`)
                                            VALUES
                                                ('{$time}', '{$date}', '{$time_exp}', '{$symbol}', '{$pos}', '1', '{$user['id']}', '0')");
                            $lastid = $mysqli->query("SELECT `user_id`, `id` FROM `users_signals` WHERE `user_id` = '{$user['id']}' ORDER BY `id` DESC LIMIT 1");
                            $lastid = $mysqli->assoc($lastid);
                            $lastid = $lastid['id'];
                            $mysqli->query("INSERT INTO `users_points` (`signal_id`, `user_id`, `point`) VALUES ('{$lastid}', '{$user['id']}', '1')");
                            $mysqli->query("UPDATE `users` SET `amount_signals` = `amount_signals` + 1 WHERE `id` = '{$user['id']}'");
                            $vb = new Reader("default");
                            $vb->view("cabinet/ready_votes");
                            $vb->change("message", "Подтверждение");
                            $vb->change("type", 1);
                            $v_box = $vb->show();

                            if($pos == 1) {
                                $pos = "up";
                            }
                            else {
                                $pos = "down";
                            }

                            $sg = new Reader("default");
                            $sg->view("cabinet/user");
                            $sg->change("photo", $user['img']);
                            $sg->change("name", $user['name']);
                            $sg->change("rank", $user['rank']);
                            $sg->change("symbol", $symbol);
                            $sg->change("time_exp", $time_exp);
                            $sg->change("time", $time);
                            $sg->change("date", $date);
                            $sg->change("id", $lastid);
                            $sg->change("pos", $pos);
                            $sg->change("interest", 100);
                            $sg->change("votes", $v_box);
                            echo $sg->show();
                        }
                        else {
                            echo 'format';
                        }
                    }
                    else {
                        echo 'data';
                    }
                }
                else {
                    echo 'data';
                }
            }
            elseif($action == "load-signals") {
                if(isset($_POST['n'])) {
                    $num = $adds->toInteger($_POST['n']);
                    $exists = $mysqli->query("SELECT * FROM `users_signals` ORDER BY `id` DESC LIMIT {$num}, 4");
                    if($exists->num_rows > 0) {
                        $users = "";
                        $signal = $mysqli->assoc($exists);
                        do {
                            $name = "Аноним";
                            $img = URI."/engine/templates/default/img/author.jpg";
                            $rank = 0;
                            $usr = $mysqli->query("SELECT `name`, `img`, `rank` FROM `users` WHERE `id` = '{$signal['user_id']}' LIMIT 1");
                            if($usr->num_rows == 1) {
                                $usr = $mysqli->assoc($usr);
                                if(!empty($usr['img'])) {
                                    $img = $usr['img'];
                                }
                                $rank = $usr['rank'];
                                $name = $usr['name'];
                            }
                            $pos = 'down';
                            if($signal['torb'] == 1) {
                                $pos = 'up';
                            }
                            $v_box = "";
                            $votes = $signal['like'] + $signal['dislike'];
                            $interest = $signal['like'] * 100 / $votes;
                            $ready_vote = $mysqli->query("SELECT `signal_id`, `user_id`, `point` FROM `users_points` WHERE `signal_id` = '{$signal['id']}' AND `user_id` = '{$user['id']}' LIMIT 1");
                            if($ready_vote->num_rows == 1) {
                                $vi = $mysqli->assoc($ready_vote);
                                $message = "Подтверждение";
                                if($vi['point'] == 0) {
                                    $message = "Отрицание";
                                }
                                $vb = new Reader("default");
                                $vb->view("cabinet/ready_votes");
                                $vb->change("message", $message);
                                $vb->change("type", $vi['point']);
                                $v_box = $vb->show();
                            }
                            else {
                                $vb = new Reader("default");
                                $vb->view("cabinet/votes");;
                                $vb->change("amount", $votes);
                                $v_box = $vb->show();
                            }
                            $sg = new Reader("default");
                            $sg->view("cabinet/user");
                            $sg->change("photo", $img);
                            $sg->change("name", $name);
                            $sg->change("rank", $rank);
                            $sg->change("symbol", $signal['symbol']);
                            $sg->change("time_exp", $signal['exp_time']);
                            $sg->change("time", $signal['time']);
                            $sg->change("date", $signal['date']);
                            $sg->change("id", $signal['id']);
                            $sg->change("pos", $pos);
                            $sg->change("interest", $interest);
                            $sg->change("votes", $v_box);
                            $users .= $sg->show();
                        }
                        while($signal = $mysqli->assoc($exists));
                        echo $users;
                    }
                    else {
                        echo "empty";
                    }
                }
                else {
                    echo "data";
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>