<?php
class Fq_elly extends Core {
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
            if($action == "change-faq" && isset($_POST['answer']) && isset($_POST['question']) && isset($_POST['id'])) {
                $answer = $adds->siftText($_POST['answer']);
                $question = $adds->siftText($_POST['question']);
                $id = $adds->toInteger($_POST['id']);
                if(!empty($answer) && !empty($question) && $id != 0) {
                    $mysqli->query("UPDATE `faq_elly` SET `title` = '{$question}', `message` = '{$answer}' WHERE `id` = '{$id}'");
                    echo "success";
                }
                else {
                    echo 'empty';
                }
            }
            elseif($action == "remove-faq" && isset($_POST['id'])) {
                $id = $adds->toInteger($_POST['id']);
                if($id != 0) {
                    $mysqli->query("DELETE FROM `faq_elly` WHERE `id` = '{$id}'");
                    $inf = new Reader("default");
                    $inf->view("cabinet/infobox");
                    $inf->change("text", "Список записей пуст");
                    echo $inf->show();
                }
                else {
                    echo 'error';
                }
            }
            elseif($action == "add-faq" && isset($_POST['answer']) && isset($_POST['question'])) {
                $answer = $adds->siftText($_POST['answer']);
                $question = $adds->siftText($_POST['question']);
                if(!empty($answer) && !empty($question)) {
                    $mysqli->query("INSERT INTO `faq_elly` (`title`, `message`) VALUES('{$question}', '{$answer}')");
                    $last = $mysqli->query("SELECT `id` FROM `faq_elly` ORDER BY `id` DESC LIMIT 1");
                    if($last->num_rows == 1) {
                        $last_id = $mysqli->assoc($last);
                        $last_id = $last_id['id'];
                        $inf = new Reader("default");
                        $inf->view("admin/fq");
                        $inf->change("id", $last_id);
                        $inf->change("title", $question);
                        $inf->change("message", $answer);
                        echo $inf->show();
                    }
                    else {
                        echo 'empty';
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