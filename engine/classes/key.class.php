<?php
class Key extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Ввод пром ключа";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Ввод промо ключа");
        $user = $adds->getUserData();
        $data = new Reader("default");
        $data->view("cabinet/key");
        echo $data->show();
    }
}
?>