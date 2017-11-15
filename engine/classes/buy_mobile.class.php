<?php
class Buy_mobile extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "TrustSignals - Список пакетов";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        global $mysqli;
        $this->initBasicData();
        $this->changeLauncher("buy");
        $user = $adds->getUserData();
        if($user['confirm'] == '1') {
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
            $fq = $mysqli->query("SELECT * FROM `packages` WHERE `type` = 'vip' OR `type` = 'vip1' ORDER BY `price` ASC");
            if($fq->num_rows > 0) {
                $f = $mysqli->assoc($fq);
                do {
                    $includes_value = "";
                    $inc_list = json_decode($f['includes']);
                    foreach ($inc_array as $key => $value) {
                      $class_name = "close";
                      if(in_array($key, $inc_list)) {
                        $class_name = "check";
                      }
                      $i_box = new Reader("default");
                      $i_box->view("buy/include");
                      $i_box->change("title", $value);
                      $i_box->change("class", $class_name);
                      $includes_value .= $i_box->show();
                    }

                    $inf = new Reader("default");
                    $inf->view("buy/packages");
                    $inf->change("id", $f['id']);
                    $inf->change("type", $f['type'] == "vip1" ? "vip" : $f['type']);
                    $inf->change("price", $f['price']);
                    $inf->change("includes", $includes_value);
                    $inf->change("time", str_replace(" 00:00", "", $adds->timeleft($f['time'])));
                    $faq .= $inf->show();
                }
                while($f = $mysqli->assoc($fq));
            }
            else {
                $inf = new Reader("default");
                $inf->view("cabinet/infobox");
                $inf->change("text", "В данный момент сервис не предоставляет пакеты");
                $faq = $inf->show();
            }


            $systems = $mysqli->query("SELECT * FROM `pay_categories` ORDER BY `id` ASC");
      			$pay_list = "";
      			$pay_systems = "";
      			if($systems->num_rows) {
      				$system = $mysqli->assoc($systems);
      				$isFirst = "active";
      				do {
      					$s = new Reader("default");
      					$s->view("buy/li_system");
      					$s->change("id", $system['id']);
      					$s->change("name", $system['name']);
      					$s->change("active", $isFirst);
      					$pay_systems .= $s->show();
      					$get_systems_list = "<p style='padding: 20px;'>Список систем для пополнения в данном разделе пуст</p>";
      					$get_syst = $mysqli->query("SELECT * FROM `pay_systems` WHERE `category_id` = '{$system['id']}' AND `status` = '1'");
      					if($get_syst->num_rows) {
      						$get_systems_list = "";
      						$g = $mysqli->assoc($get_syst);
      						do {
      							$gtmp = new Reader("default");
      							$gtmp->view("buy/item_system");
      							$gtmp->change("system", $g['system']);
      							$gtmp->change("img", $g['img']);
      							$gtmp->change("name", $g['name']);
      							$get_systems_list .= $gtmp->show();
      						}
      						while($g = $mysqli->assoc($get_syst));
      					}
      					$s_wrap = new Reader("default");
      					$s_wrap->view("buy/wrap_systems");
      					$s_wrap->change("list", $get_systems_list);
      					$s_wrap->change("id", $system['id']);
      					$s_wrap->change("active", $isFirst);
      					$pay_list .= $s_wrap->show();
      					$isFirst = "";
      				}
      				while($system = $mysqli->assoc($systems));
      			}

            $this->templateEdit("systems", $pay_systems);
            $this->templateEdit("list_systems", $pay_list);

            $data = new Reader("default");
            $data->view("buy/buy");
            $data->change("content", $faq);
            $data->change("uri", URI);
            $data->change("systems", $pay_systems);
      			$data->change("list_systems", $pay_list);
            echo $data->show();
        }
        else {
            $confirm = new Reader("default");
            $confirm->view("cabinet/confirm");
            $confirm->change("uri", URI);
            echo $confirm->show();
        }
    }
}
?>
