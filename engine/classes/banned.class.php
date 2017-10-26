<?php
class Banned extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $date = date("Y-m-d");
        global $mysqli;
        $user = $adds->getUserData();
        $ban = new Reader("default");
        $ban->view("cabinet/banned");
        $ban->change("uri", URI);
        $ban->change("banned", $user["banned"]);
        echo $ban->show();
    }
}
?>