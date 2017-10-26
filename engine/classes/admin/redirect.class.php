<?php
class Redirect extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Перелинковка - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $user = $adds->getUserData();
        $this->templateEdit("title_content", "Перелинковка");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {

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

            $fq = $mysqli->query("SELECT * FROM `links` ORDER BY `id` DESC LIMIT {$to}, {$limit}");
            $amount = $mysqli->query("SELECT `id` FROM `links`")->num_rows;
            $rec = "";
            $data = new Reader("default");
            $data->view("admin/links");
            $data->change("URI", URI);
            if($fq->num_rows > 0) { 
                $f = $mysqli->assoc($fq);
                do {
                    $inf = new Reader("default");
                    $inf->view("admin/link");
                    $inf->change("id", $f['id']);
                    $inf->change("link", $f['link']);
                    $inf->change("description", $f['description']);
                    $inf->change("views", $f['views']);
                    $inf->change("reg", $f['reg']);
                    $inf->change("URI", URI);
                    $rec .= $inf->show();
                }
                while($f = $mysqli->assoc($fq));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список записей пуст");
                $rec = $inf->show();
            }
            $data->change("links", $rec);
            echo $data->show();
            echo $adds->pageNav($page_num, $amount);
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