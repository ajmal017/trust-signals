<?php
class News extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Экономические новости - Панель управления";
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
        $this->templateEdit("title_content", "Экономические новости");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {
            $add = new Reader("default");
            $add->view("admin/add_news");
            echo $add->show();
            echo "<div id='news' class='col-md-12'>";
            $fq = $mysqli->query("SELECT * FROM `economic_news` ORDER BY `id` DESC");
            if($fq->num_rows > 0) {
                $f = $mysqli->assoc($fq);
                do {
                    $time = date("Y-m-d H:i", $f['date']);
                    $inf = new Reader("default");
                    $inf->view("admin/news");
                    $inf->change("id", $f['id']);
                    $inf->change("date", $time);
                    echo $inf->show();
                }
                while($f = $mysqli->assoc($fq));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список экономических новостей пуст");
                echo $inf->show();
            }
            echo '</div>';
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