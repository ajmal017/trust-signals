<?php
class Patterns extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        $date = date("Y-m-d");
        $user = $adds->getUserData();
        if($adds->isAuth() && ( $user['group'] == 'admin' || $user['group'] == 'moder') ) {
            if($action == "change-pattern" && isset($_POST['file']) && isset($_POST['message'])) {
                $text = $_POST['message'];
                $file = $adds->siftText($_POST['file']);
                if(!empty($text)) {
                    if(file_exists($file)) {
                        file_put_contents($file, $text);
                        echo 'success';
                    }
                    else {
                        echo 'error.file not exist: '. $file;
                    }
                }
                else {
                    echo 'empty';
                }
            }
        }
        else {
            echo "<p>Проблема аутентификации</p>";
        }
    }
}
?>