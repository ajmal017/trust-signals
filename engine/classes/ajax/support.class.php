<?php
header('Access-Control-Allow-Origin: *');
class Support extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $action = '';
        if(isset($_POST['action'])) {
            $action = $_POST['action'];
        }
        global $mysqli;
        if($adds->isAuth()) {
            $user = $adds->getUserData();
            if($action == "send") {
                if(isset($_POST['subject']) && isset($_POST['text'])) {
                    $subject = $adds->siftText($_POST['subject']);
                    $text = $adds->siftText($_POST['text']);
                    if(!empty($text) && !empty($subject)) {
                        $date = date("Y-m-d");
                        $date_time = date("Y-m-d H:i:s");
                        $mysqli->query("INSERT INTO `support` (`text`, `subject`, `user_id`, `email`, `date`) VALUES ('{$text}', '{$subject}', '{$user['id']}', '{$user['email']}', '{$date_time}')");
                        $mysqli->query("INSERT INTO `_mails` (`user_id`, `text`, `date`, `status`, `side`) VALUES ('{$user['id']}', '{$text}', '{$date}', '1', '1')");
                        $res = new Reader("default");
                        $res->view("admin/supp_dialog_rec");
                        $res->change("img", $user['img']);
                        $res->change("subject", $subject);
                        $res->change("text", $text);
                        $res->change("date", $date_time);
                        $res->change("pos", "out");
                        echo $res->show();
                    }
                    else {
                        echo 'empty';
                    }
                }
                else {
                    echo 'data';
                }
            }
        }
        else {
            echo "auth";
        }
    }
}
?>