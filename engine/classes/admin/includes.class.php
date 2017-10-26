<?php
class Includes extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Описание пакетов - Панель управления";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->templateEdit("title_content", "Описание пакетов");
        $user = $adds->getUserData();
        if($user['group'] == 'admin') {
          $includes = $mysqli->query("SELECT * FROM `packages_includes`");
    			$inc_array = array();
    			if($includes->num_rows) {
    				$inc = $mysqli->assoc($includes);
    				do {
    					$inc_array[$inc['id']] = $inc['title'];
    				}
    				while($inc = $mysqli->assoc($includes));
    			}
    			$faq = "";
    			$fq = $mysqli->query("SELECT * FROM `packages` ORDER BY `type` DESC, `price` ASC");
    			if($fq->num_rows > 0) {
    				$f = $mysqli->assoc($fq);
    				do {
    					if($f['type'] != "vip1") {
    						$includes_value = "";
    						$inc_list = json_decode($f['includes']);
    						foreach ($inc_array as $key => $value) {
    							$class_name = "";
    							if(in_array($key, $inc_list)) {
    								$class_name = "checked";
    							}
    							$i_box = new Reader("default");
    							$i_box->view("admin/include");
    							$i_box->change("title", $value);
    							$i_box->change("class", $class_name);
                  $i_box->change("id", $key);
    							$includes_value .= $i_box->show();
    						}
    						$inf = new Reader("default");
    						$inf->view("admin/packages");
    						$inf->change("id", $f['id']);
    						$inf->change("type", $f['type']);
    						$inf->change("price", $f['price']);
    						$inf->change("includes", $includes_value);
    						$inf->change("time", str_replace(" 00:00", "", $adds->timeleft($f['time'])));
    						$faq .= $inf->show();
    					}
    				}
    				while($f = $mysqli->assoc($fq));
          }

          $data = new Reader("default");
          $data->view("admin/includes");
          $data->change("list", $list);
          $data->change("packs", $faq);
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
