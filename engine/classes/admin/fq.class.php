<?php
class Fq extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "FAQ - Панель управления";
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
        $this->templateEdit("title_content", "Ответы на частые вопросы");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {

            $inf = new Reader("default");
            $inf->view("admin/faq");
            echo $inf->show()."<div id='aqs'>";

            $fq = $mysqli->query("SELECT `title`, `id`, `message` FROM `faq` ORDER BY `id` DESC");
            if($fq->num_rows > 0) {
                $f = $mysqli->assoc($fq);
                do {
                    $inf = new Reader("default");
                    $inf->view("admin/fq");
                    $inf->change("id", $f['id']);
                    $inf->change("title", $f['title']);
                    $inf->change("message", $f['message']);
                    echo $inf->show();
                }
                while($f = $mysqli->assoc($fq));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список записей пуст");
                $faq = $inf->show();
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