<?php
class Pay extends Core {
    public function getTitle() {
        $adds = new Additions();
        if($adds->isAuth()) {
            echo "Проведение оплаты";
        }
        else {
            $adds->redirect(URI."/home/");
        }
    }
    public function getContent() {
        $adds = new Additions();
        $date = date("Y-m-d");
        global $mysqli;
        $this->initBasicData();
        $user = $adds->getUserData();
        $this->templateEdit("title_content", "Проведение оплаты");
        $pay_res = "";

        if(isset($_REQUEST["OutSum"])) {
            $mrh_pass1 = "12345678a";
            $out_summ = $_REQUEST["OutSum"];
            $inv_id = $_REQUEST["InvId"];
            $package_id = $_REQUEST['Shp_item'];
            $crc = $_REQUEST["SignatureValue"];
            $crc = strtoupper($crc);
            $my_crc = strtoupper(md5("{$out_summ}:{$inv_id}:{$mrh_pass1}:Shp_item={$package_id}"));
            if (strtoupper($my_crc) != strtoupper($crc)) {
                $ib = new Reader("default");
                $ib->view("cabinet/infobox");
                $ib->change("text", "Произошла ошибка при оплате");
                $pay_res = $ib->show();
                $adds->redirectDelay(URI."/cabinet/", 2000);
            }
            else {
                $adds->checkPayment($inv_id, $package_id, $out_summ, $user['id']);
                unset($_REQUEST["OutSum"]);
            }
        }
        elseif(isset($_POST['ik_co_id'])) {
            $ik_co_id = $adds->siftText($_POST['ik_co_id']);
            $ik_pm_no = $adds->siftText($_POST['ik_pm_no']);
            $ik_inv_id = $adds->siftText($_POST['ik_inv_id']);
            $ik_inv_st = $adds->siftText($_POST['ik_inv_st']);
            if(INTERKASSA_KEY == $ik_co_id && $ik_inv_st == 'success') {
                $package = $mysqli->query("SELECT `package_id`, `summ` FROM `orders` WHERE `id` = '{$ik_pm_no}' LIMIT 1");
                if($package->num_rows == 1) {
                    $course = 60;
                    $course_tmp = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'course' LIMIT 1");
                    if($course_tmp->num_rows == 1) {
                        $course_tmp = $mysqli->assoc($course_tmp);
                        $course = $adds->toInteger($course_tmp['value']);
                    }
                    $package = $mysqli->assoc($package);
                    $summ = $package['summ'] * $course;
                    $package = $package['package_id'];
                    $adds->checkPayment($ik_pm_no, $package, $summ, $user['id']);
                    unset($_POST['ik_pm_no']);
                }
                else {
                    $ib = new Reader("default");
                    $ib->view("cabinet/infobox");
                    $ib->change("text", "Произошла ошибка при оплате");
                    $pay_res = $ib->show();
                    $adds->redirectDelay(URI."/cabinet/", 2000);
                }
            }
            else {
                $ib = new Reader("default");
                $ib->view("cabinet/infobox");
                $ib->change("text", "Произошла ошибка при оплате");
                $pay_res = $ib->show();
                $adds->redirectDelay(URI."/cabinet/", 2000);
            }
        }
        else {
            $ib = new Reader("default");
            $ib->view("cabinet/infobox");
            $ib->change("text", "Произошла ошибка при оплате");
            $pay_res = $ib->show();
            $adds->redirectDelay(URI."/cabinet/", 2000);
        }

        $data = new Reader("default");
        $data->view("buy/buy");
        $data->change("content", $pay_res);
        $data->change("uri", URI);
        echo $data->show();
    }
}
?>