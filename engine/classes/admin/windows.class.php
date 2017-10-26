<?php
class Windows extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Окна - Панель управления";
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
        $this->templateEdit("title_content", "Управление окнами");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {

            $inf = new Reader("default");
            $inf->view("admin/windows");
            echo $inf->show()."<div id='aqs'>";

            $fq = $mysqli->query("SELECT * FROM `windows` ORDER BY `id` DESC");
            if($fq->num_rows > 0) {
                $f = $mysqli->assoc($fq);
                do {
                    $inf = new Reader("default");
                    $inf->view("admin/window");
                    $inf->change("id", $f['id']);
                    $inf->change("title", $f['title']);
                    $inf->change("lang", $f['lang']);
                    $inf->change("time", $f['time']);
                    $inf->change("lang_big", strtoupper($f['lang']));
                    $inf->change("text", $f['text']);
                    echo $inf->show();
                }
                while($f = $mysqli->assoc($fq));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список записей пуст");
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