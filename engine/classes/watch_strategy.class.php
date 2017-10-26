<?php
class Watch_strategy extends Core {
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
            if(( $user['time_vip'] > 0 || $user['timeleft'] > 0 ) && $user['confirm'] == '1' /*&& date("l") != "Saturday" &&  date("l") != "Sunday"*/) {
                $str_res = "";
                if(( $user['time_vip'] > 0 || $user['timeleft'] > 0 )) {
                    if(isset($_GET['id'])) {
                        $id = $adds->toInteger($_GET['id']);
                        $search_atricle = $mysqli->query("SELECT * FROM `strategies` WHERE `id` = '{$id}' LIMIT 1");
                        if($search_atricle->num_rows == 1) {
                            $row = $mysqli->assoc($search_atricle);
                            $desc = strip_tags($row['text']);
                            if(strlen($desc) > 400) {
                                $desc = substr($desc, 0, 400).'...';
                            }
                            $tmp = new Reader("default");
                            $tmp->view("pages/watch_str");
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
                            $str_res = new Reader("default");
                            $str_res->view("cabinet/infobox");
                            $str_res->change("text", "Произошла ошибка при попытке доступа к стратегии, возможно данной стратегии не существует");
                            $str_res = $str_res->show();
                        }
                    }
                    else {
                        $str_res = new Reader("default");
                        $str_res->view("cabinet/infobox");
                        $str_res->change("text", "Произошла ошибка при попытке доступа к стратегии, возможно данной стратегии не существует");
                        $str_res = $str_res->show();
                    }
                }
                else {
                    $str_res = new Reader("default");
                    $str_res->view("cabinet/infobox");
                    $str_res->change("text", "Ваше время для базового и vip кабинета истекло | <a href='".URI."/buy/'>купить доступ здесь</a>");
                    $str_res = $str_res->show();
                }
                $str_cabinet = $str_res;
                echo $str_cabinet;
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