<?php
class Users extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Список пользователей - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
	
	
	
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Список пользователей");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
            $page_num = 1;
            if(isset($_GET['num'])) {
                $page_num = $adds->toInteger($_GET['num']);
            }
            if($page_num == 0) {
                $page_num = 1;
            }
            $to = 0;
            $limit = 10;
            if($page_num > 1) {
                $to = $page_num * $limit - $limit;
            }
            $to = $adds->toInteger($to);
            $limit = $adds->toInteger($limit);
            $wrap = new Reader("default");
            $wrap->view("admin/users");
            $wrap->change("uri", URI);
            $where = "";
            if(isset($_GET['search'])) {
                $str = $_GET['search'];
                $str = str_replace("+", " ", $str);
                $where = "WHERE `name` LIKE '%$str%' OR `email` LIKE '%$str%'";
            }
            $usr_tmp = $mysqli->query("SELECT * FROM `users` {$where} ORDER BY `id` DESC LIMIT {$to}, {$limit}");
            $amount = $mysqli->query("SELECT `id` FROM `users` {$where}")->num_rows;
            if($usr_tmp->num_rows > 0) {
                $u = $mysqli->assoc($usr_tmp);
                $usr = "";
                do {
                    $img = $u['img'];
                    if(empty($img)) {
                        $img = URI."/engine/templates/default/img/author.jpg";
                    }
                    $ub = new Reader("default");
                    $ub->view("admin/usr_rec");
                    $online = '<span class="label label-danger">offline</span>';
                    $m_lasttime = round((time() - $u['lasttime']) / 60);
                    if($m_lasttime <= 3)
                        $online = '<span class="label label-success">online</span>';
                    $ub->change("user_id", $u['id']);
                    $ub->change("email", $u['email']);
                    $ub->change("status", $online);
                    if($u['time_vip'] > 0) {
                        $ub->change("type", "<span class='glyphicon glyphicon-certificate golden-color'></span>");
                    }
                    else {
                        $ub->change("type", "");
                    }
					
                    $soc_url = 'Не указана';
                    if(!empty($u['soc_url'])) { $soc_url = $u['soc_url']; }
                    $reg_from = "trust-signals.com";
                    if($u['auth_type'] == 'vk') $reg_from = "ВКонтакте";
                    if($u['auth_type'] == 'ok') $reg_from = "Однокласники";
                    if($u['auth_type'] == 'ya') $reg_from = "Яндекс Почта";
                    $ub->change("name", $u['name']);
                    $ub->change("date", $u['date']);
                    $btn_act = "";
                    if($u['confirm'] == '0') {
                        $btn_act = '<span data-toggle="tooltip" data-placement="top" title="Активировать" data-id="'.$u['id'].'" class="activate-user moderation-link label label-danger"><span class="glyphicon glyphicon-ok"></span></span>';
                    }
                    $ub->change("activate_user", $btn_act);
                    $ub->change("timeleft", $adds->timeleft($u['timeleft']));
                    $ub->change("time_vip", $adds->timeleft($u['time_vip']));
                    $ub->change("address", $soc_url);
                    $ub->change("from_reg", $reg_from);
                    $ub->change("user_img", $img);

                    if(!empty($u['banned'])) {
                        $ub->change("banned", "<span class='unlock-banned-usr' data-id='{$u['id']}'><span class='fa fa-unlock'></span> Убрать бан</span> | <a href='#' data-message='{$u['banned']}' class='show-banned-message'>причина</a>");
                    }
                    else {
                        $ub->change("banned", "<span class='lock-banned-usr' data-id='{$u['id']}'><span class='fa fa-lock'></span> Блокировать</span>");
                    }

                    $usr .= $ub->show();
                }
                while($u = $mysqli->assoc($usr_tmp));
                $wrap->change("users", $usr);
                $pref = "";
                if(isset($_GET['search'])) {
                    $str = $_GET['search'];
                    $pref = str_replace(' ', '+', $str).'_';
                }
                $wrap->change("page_nav", $adds->pageNav($page_num, $amount, $pref));
                $this_time = time();
                $amusers = $mysqli->query("SELECT `lasttime` FROM `users` WHERE $this_time - `lasttime` <= 5*60")->num_rows;
                $wrap->change("aonline", $amusers);

                $worlds_list = "";

                $wl = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'tmp-list' LIMIT 1");
                if($wl->num_rows == 1) {
                    $wl = $mysqli->assoc($wl);
                    $worlds_list = $wl['value'];
                }

                $wrap->change("tmp-list", $worlds_list);
                
                echo $wrap->show();
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список пользователей пуст");
                echo $inf->show();
            }
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