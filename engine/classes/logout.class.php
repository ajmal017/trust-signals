<?php
class Logout extends Core {
    public function getTitle() {
        echo "Добро пожаловать на Option-Signal";
    }
    public function getContent() {
        $this->changeLauncher("home");
        $adds = new Additions();
        if(!$adds->isAuth()) {
            $adds->redirect(URI."/home/");
        }
        else {
            unset($_SESSION['user']);
            $adds->redirect(URI."/home/");
        }
    }
}
?>