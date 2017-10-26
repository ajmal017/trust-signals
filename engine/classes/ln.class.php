<?php
class Ln extends Core {
    public function getTitle() {
        echo "Добро пожаловать на Option-Signal";
    }
    public function getContent() {
        global $mysqli;
        $this->changeLauncher("home");
        $adds = new Additions();
        if(isset($_GET['id'])) {
            $id = $adds->toInteger($_GET['id']);
            $url = $mysqli->query("SELECT `id`, `link` FROM `links` WHERE `id` = '{$id}' LIMIT 1");
            if($url->num_rows == 1) {
                $url = $mysqli->assoc($url);
                $url = $url['link'];

                if(preg_match("#".URI."#", $url)) {
                    setcookie("amount-orders", "1", time()  + (7 * 24 * 60 * 60), "/");
                }

                if(!isset($_COOKIE["ln-{$id}"])) {
                    $mysqli->query("UPDATE `links` SET `views` = `views` + 1 WHERE `id` = '{$id}'");
                }
                setcookie("ln-{$id}", "1", time() + (7 * 24 * 60 * 60));
                $adds->redirect($url);
            }
            else {
                $adds->redirect(URI."/home/");
            }
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>