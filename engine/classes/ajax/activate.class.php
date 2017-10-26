<?php
class Activate extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("clean");
        $adds = new Additions();
        $date = date("Y-m-d");
        global $mysqli;
        if(isset($_GET['email'])) {
            $email = $_GET['email'];
            $usr = $mysqli->query("SELECT `name`, `email` FROM `users` WHERE MD5(`email`) = '{$email}' LIMIT 1");
            if($usr->num_rows == 1) {
                $usr = $mysqli->assoc($usr);
                $mysqli->query("UPDATE `users` SET `confirm` = '1' WHERE MD5(`email`) = '{$email}'");
                $mail_md5 = md5($email);
                $name = explode(" ", $usr['name']);
                $name = $name[0];
                $mess = "";
                $m_box = new Reader("default");
                $m_box->view("patterns/activate");
                $m_box->change("email", $usr['email']);
                $m_box->change("name", $name);
                $m_box->change("uri", URI);
                $mess = $m_box->show();
                $adds->sendMail($usr['email'], "Активация -  trust-signals.com", $mess);
            }
            $adds->redirect(URI."/home/");
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
}
?>