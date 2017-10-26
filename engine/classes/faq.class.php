<?php
class Faq extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Ответы на частые вопросы";
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

        $faq = "";
        $fq = $mysqli->query("SELECT `title`, `id`, `message` FROM `faq`");
        if($fq->num_rows > 0) {
            $f = $mysqli->assoc($fq);
            do {
                $inf = new Reader("default");
                $inf->view("cabinet/faq");
                $inf->change("id", $f['id']);
                $inf->change("title", $f['title']);
                $inf->change("message", $f['message']);
                $faq .= $inf->show();
            }
            while($f = $mysqli->assoc($fq));
        }
        else {
            $inf = new Reader("default");
            $inf->view("cabinet/infobox");
            $inf->change("text", "Страница \"Ответы на частые вопросы\" пустая");
            $faq = $inf->show();
        }

        $data = new Reader("default");
        $data->view("cabinet/faq_wrapper");
        $data->change("content", $faq);
        $data->change("uri", URI);
        echo $data->show();
    }
}
?>