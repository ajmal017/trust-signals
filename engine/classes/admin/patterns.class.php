<?php
class Patterns extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Шаблоны - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $user = $adds->getUserData();
        $this->templateEdit("title_content", "Шаблоны");
        if($user['group'] == 'admin' || $user['group'] == 'moder') {
            $list_name = array(
                "activate.php" => "activate.php - письмо активации пользователя",
                "recovery.php" => "recovery.php - письмо восстановления пароля",
                "template.php" => "template.php - письмо для пользователя",
                "register.php" => "register.php - письмо регистрации пользователя"
            );
            $tmps = glob(ROOT."/engine/templates/default/patterns/*");
            if(count($tmps) > 0) {
                foreach($tmps as $key => $value):
                    if(is_file($value)) {
                        $content = file_get_contents($value);
                        $fname = basename($value);
                        if(isset($list_name[$fname])) {
                            $fname = $list_name[$fname];
                        }
                        $inf = new Reader("default");
                        $inf->view("admin/pattern");
                        $inf->change("id", $key);
                        $inf->change("title", $fname);
                        $inf->change("file", $value);
                        $inf->change("message", $content);
                        echo $inf->show();
                    }
                endforeach;
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "Список шаблонов пуст");
                $faq = $inf->show();
            }
        }
        else {
            $lock = new Reader("default");
            $lock->view("admin/lock");
            $lock->change("uri", URI);
            echo $lock->show();
        }
    }
}
?>