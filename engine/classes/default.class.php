<?php
class Default extends Core {
    public function getTitle() {
        echo "Доступ для VIP клиентов";
    }
    public function getContent() {
        $adds = new Additions();
        if($adds->isAuth()) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $this->templateEdit("title_content", "Доступ для VIP клиентов");
            $user = $adds->getUserData();
            if($user['time_vip'] > 0 && $user['confirm'] == '1' && date("l") != "Saturday" &&  date("l") != "Sunday") {
                echo "<h1>Контент страницы \"deafult\" для VIP</h1>";
            }
            else {
                if(date("l") == "Saturday" ||  date("l") == "Sunday") {
                    $output = new Reader("default");
                    $output->view("cabinet/output");
                    echo $output->show();
                }
                elseif($user['confirm'] == '0') {
                    $confirm = new Reader("default");
                    $confirm->view("cabinet/confirm");
                    $confirm->change("uri", URI);
                    echo $confirm->show();
                }
                else {
                    $lock = new Reader("default");
                    $lock->view("cabinet/lock");
                    $lock->change("uri", URI);
                    echo $lock->show();
                }
            }
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>