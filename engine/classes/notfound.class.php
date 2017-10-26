<?php
class Notfound extends Core {
    public function getTitle() {
        echo "Страница не найдена - Ошибка 404";
    }
    public function getContent() {
        $this->changeLauncher("notfound");
        $adds = new Additions();
    }
}
?>