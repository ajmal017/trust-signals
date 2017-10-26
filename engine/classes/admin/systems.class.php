<?php
class Systems extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Платежние системы - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Платежние системы");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
          $list = "Список систем пуст";
          $systems = $mysqli->query("SELECT * FROM `pay_categories` ORDER BY `id` ASC");
  				if($systems->num_rows) {
            $list = "";
  					$system = $mysqli->assoc($systems);
  					do {
              $list .= "<h3>{$system['name']}</h3>";
  						$get_syst = $mysqli->query("SELECT * FROM `pay_systems` WHERE `category_id` = '{$system['id']}'");
  						if($get_syst->num_rows) {
  							$get_systems_list = "";
  							$g = $mysqli->assoc($get_syst);
  							do {
                  $s_box = new Reader("default");
                  $s_box->view("admin/system");
                  $s_box->change("name", $g['name']);
                  $s_box->change("img", $g['img']);
                  $s_box->change("id", $g['id']);
                  $s_box->change("checked", $g['status'] ? "checked" : "");
                  $list .= $s_box->show();
  							}
  							while($g = $mysqli->assoc($get_syst));
  						}
  					}
  					while($system = $mysqli->assoc($systems));
  				}
          $data = new Reader("default");
          $data->view("admin/systems");
          $data->change("list", $list);
          echo $data->show();
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
