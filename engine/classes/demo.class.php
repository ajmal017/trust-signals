<?php
class Demo extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $date = date("Y-m-d");
        $adds = new Additions();
        global $mysqli;
        $res = new Reader("default");
        $res->view("demo/demo");
        echo $res->show();
    }
}
?>