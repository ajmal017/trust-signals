<?php
class Additions
{
    private $_user;
    
    public function __construct()
    {
        session_start();
        $this->setView();
        if (isset($_SESSION['user'])) {
            $this->_user = $this->toInteger($_SESSION['user']);
            if (!$this->getUserData()) {
                $this->redirect(URI . "/home/");
            }
        } else {
            $this->_user = 0;
        }
    }
    
    public function set($key)
    {
        global $mysqli;
        $set = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = '{$key}' LIMIT 1");
        if ($set->num_rows) {
            $set = $mysqli->assoc($set);
            return $set['value'];
        }
        return false;
    }
    
    function baseOptimizationSize($base)
    {
        global $mysqli;
        $along  = 0;
        $tables = $mysqli->query("SHOW TABLES");
        if ($tables->num_rows > 0) {
            $table = $mysqli->assoc($tables);
            do {
                $t_name = $table["Tables_in_{$base}"];
                $data   = $mysqli->query("SHOW TABLE STATUS FROM `{$base}` LIKE '{$t_name}'");
                if ($data->num_rows > 0) {
                    $size = $mysqli->assoc($data);
                    $along += ($size['Index_length'] + $size['Data_length']);
                }
            } while ($table = $mysqli->assoc($tables));
        }
        
        $translate = array(
            ' Б',
            ' КБ',
            ' МБ',
            ' ГБ',
            ' ТБ'
        );
        for ($k = 0; $along > 1024; $k++):
            $along /= 1024;
        endfor;
        return round($along, 2) . $translate[$k];
    }
    
    public function checkPayment($inv_id, $package_id, $out_summ, $usr, $format = true)
    {
        global $mysqli;
        $user       = $this->getUserData();
        $user['id'] = $usr;
        $date       = date("Y-m-d");
        $check      = $mysqli->query("SELECT * FROM `orders` WHERE `id` = '{$inv_id}' AND `status` = '0' LIMIT 1");
        if ($check->num_rows == 1) {
            $package = $mysqli->query("SELECT * FROM `packages` WHERE `id` = '{$package_id}' LIMIT 1");
            if ($package->num_rows == 1) {
                $package = $mysqli->assoc($package);
                $type    = $package['type'];
                $minutes = $package['time'];
                if ($user['rank'] >= 70) {
                    $minutes += $minutes * 10 / 100;
                }
                
                $persent_int = 20;
                $persent_db  = $mysqli->query("SELECT * FROM `persent` WHERE `id`='1'");
                if ($persent_db->num_rows == 1) {
                    $p_db_f_a    = $persent_db->fetch_assoc();
                    $persent_int = $p_db_f_a["persent"];
                }
                $course     = 60;
                $course_tmp = $mysqli->query("SELECT `title`, `value` FROM `settings` WHERE `title` = 'course' LIMIT 1");
                if ($course_tmp->num_rows == 1) {
                    $course_tmp = $mysqli->assoc($course_tmp);
                    $course     = $this->toInteger($course_tmp['value']);
                }
                
                $persent   = $out_summ / $course * $persent_int / 100;
                $id        = $user['id'];
                $isset_ref = $mysqli->query("SELECT * FROM `aff_list` WHERE `spk_id` = '{$id}'");
                if ($isset_ref->num_rows == 1) {
                    $ref       = $isset_ref->fetch_assoc();
                    $isset_aff = $mysqli->query("SELECT `id`, `balance` FROM `user_aff` WHERE id = '{$ref['aff_id']}'");
                    if ($isset_aff->num_rows == 1) {
                        $id_aff  = $ref['aff_id'];
                        $isset_r = $mysqli->query("SELECT `aff_id`, `ref_id` FROM `ref_list` WHERE `ref_id` = '{$id_aff}' LIMIT 1");
                        if ($isset_r->num_rows == 1) {
                            $id_ref       = $mysqli->assoc($isset_r);
                            $id_ref       = $id_ref['aff_id'];
                            $isset_day    = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND `user` = '{$id_ref}'");
                            $persent_half = $persent * $persent_int / 100;
                            if ($isset_day->num_rows == 1) {
                                $mysqli->query("UPDATE `history` SET `deposit` = `deposit` + 1, `ref_profit` = `ref_profit` + {$persent_half} WHERE `date` = '{$date}' AND `user` = '{$id_ref}'");
                            } else {
                                $mysqli->query("INSERT INTO `history` (`date`, `user`, `deposit`, `ref_profit`) VALUES ('{$date}', '{$id_ref}', '1', '{$persent_half}')");
                            }
                            $mysqli->query("UPDATE `user_aff` SET `balance` = `balance` + {$persent_half} WHERE `id` = '{$id_ref}'");
                            $persent = $persent - $persent_half;
                        }
                        $isset_day = $mysqli->query("SELECT * FROM `history` WHERE `date` = '{$date}' AND `user` = '{$id_aff}'");
                        if ($isset_day->num_rows == 1) {
                            $mysqli->query("UPDATE `history` SET `deposit` = `deposit` + 1, `profit` = `profit` + {$persent} WHERE `date` = '{$date}' AND `user` = '{$id_aff}'");
                            $mysqli->query("UPDATE `aff_list` SET `money` = `money` + {$persent} WHERE `aff_id` = '{$id_aff}' AND `spk_id` = '{$id}'");
                        } else {
                            $mysqli->query("INSERT INTO `history` (`date`, `user`, `deposit`, `profit`) VALUES ('{$date}', '{$id_aff}', '1', '{$persent}')");
                            $mysqli->query("UPDATE `aff_list` SET `money` = `money` + {$persent} WHERE `aff_id` = '{$id_aff}' AND `spk_id` = '{$id}' ");
                        }
                        $mysqli->query("UPDATE `user_aff` SET `balance` = `balance` + {$persent} WHERE `id` = '{$id_aff}'");
                    }
                }
                if (isset($_COOKIE['amount-orders'])) {
                    $mysqli->query("UPDATE `links` SET `reg` = `reg` + 1 WHERE `link` = 'http://trust-signals.com'");
                }
                if ($type == 'vip' || $type == 'vip1') {
                    if ($type == 'vip1') {
                        $mysqli->query("UPDATE `users` SET `vip_1` = '1' WHERE `id` = '{$user['id']}'");
                    }
                    $mysqli->query("UPDATE `users` SET `time_vip` = `time_vip` + {$minutes} WHERE `id` = '{$user['id']}'");
                    $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + {$minutes} WHERE `id` = '{$user['id']}'");
                } else {
                    $days_of_amount = ceil($minutes / 60 / 24) * 15;
                    $mysqli->query("UPDATE `users` SET `timeleft` = `timeleft` + {$minutes}, `lasttime_15` = `lasttime_15` + {$days_of_amount}, `lasttime_30` = `lasttime_30` + {$days_of_amount} WHERE `id` = '{$user['id']}'");
                }
                $mysqli->query("UPDATE `orders` SET `status` = '1' WHERE `id` = '{$inv_id}'");
                $res_sum = $out_summ / $course;
                if ($this->isDaily()) {
                    $mysqli->query("UPDATE `statistic` SET `pays` = `pays` + 1, `prefit` = `prefit` + $res_sum WHERE `date` = '{$date}'");
                } else {
                    $mysqli->query("INSERT INTO `statistic` (`date`, `views`, `prefit`, `pays`, `count_reg`) VALUES ('{$date}', '0', '{$res_sum}', '1', '0')");
                }
                if (!$format) {
                    return "Баланс успешно пополнен!";
                } else {
                    $ib = new Reader("default");
                    $ib->view("cabinet/infobox");
                    $ib->change("text", "Баланс успешно пополнен!");
                    echo $ib->show();
                    $this->redirectDelay(URI . "/cabinet/", 2000);
                }
            } else {
                if (!$format) {
                    return "Произошла ошибка при оплате";
                } else {
                    $ib = new Reader("default");
                    $ib->view("cabinet/infobox");
                    $ib->change("text", "Произошла ошибка при оплате");
                    echo $ib->show();
                    $this->redirectDelay(URI . "/cabinet/", 2000);
                }
            }
        } else {
            if (!$format) {
                return "Произошла ошибка при оплате";
            } else {
                $ib = new Reader("default");
                $ib->view("cabinet/infobox");
                $ib->change("text", "Произошла ошибка при оплате");
                echo $ib->show();
                $this->redirectDelay(URI . "/cabinet/", 2000);
            }
        }
    }
	
    public function usersAmound()
    {
        global $mysqli;
        return $mysqli->query("SELECT `id` FROM `users`")->num_rows;
    }
	
    public function sendMail($email, $subject, $message)
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = "UTF-8";
        $mail->From       = SMTP_EMAIL;
        $mail->FromName   = "Option-signal";
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject   = $subject;
        $mail->Body      = $message;
        $mail->SMTPDebug = 0;
        if ($mail->send())
            return true;
        else
            return false;
    }
	
    public function setView()
    {
        global $mysqli;
        $date = date("Y-m-d");
        if (!isset($_SESSION['view-save'])) {
            if ($this->isDaily()) {
                $mysqli->query("UPDATE `statistic` SET `views` = `views` + 1 WHERE `date` = '{$date}'");
            } else {
                $mysqli->query("INSERT INTO `statistic` (`date`, `count_reg`, `pays`,`prefit`, `views`) VALUES ('$date', '0', '0', '0', '1')");
            }
        }
        $_SESSION['view-save'] = "isset";
    }
	
    public function isAuth()
    {
        if ($this->_user != 0)
            return true;
        else
            return false;
    }
	
    public function toInteger($int)
    {
        return abs((int) $int);
    }
	
    public function siftText($html, $power = 1)
    {
        $html = str_replace("<", "&lt;
", $html);
        $html = str_replace("<", "&gt;
", $html);
        if ($power)
            $html = str_replace("'", "\\'", $html);
        $html = trim($html);
        return $html;
    }
	
    public function uniqName()
    {
        return md5(uniqid());
    }
	
    public function getAmountMails()
    {
        global $mysqli;
        $id     = $this->_user;
        $am     = $mysqli->query("SELECT COUNT(*) AS `count` FROM `_mails` WHERE `user_id` = '{$id}' AND `status` = '0'");
        $amount = $mysqli->assoc($am);
        $amount = $amount['count'];
        return $amount;
    }
	
    public function getAmountNotification()
    {
        global $mysqli;
        $id     = $this->_user;
        $am     = $mysqli->query("SELECT COUNT(*) AS `count` FROM `alerts` WHERE `user_id` = '{$id}' AND `status` = '1'");
        $amount = $mysqli->assoc($am);
        $amount = $amount['count'];
        return $amount;
    }
	
    public function getUserData()
    {
        global $mysqli;
        $id   = $this->_user;
        $user = $mysqli->query("SELECT * FROM `users` WHERE `id` = '{$id} LIMIT 1'");
        if ($user->num_rows == 1) {
            $data = $mysqli->assoc($user);
            if (empty($data['img'])) {
                $data['img'] = URI . "/engine/templates/default/img/author.jpg";
            }
            return $data;
        } else {
            unset($_SESSION['user']);
        }
        return false;
    }
	
    public function getLestTimeCabinet()
    {
        $data = $this->getUserData();
        return $data['timeleft'];
    }
	
    public function getLestTimeVIP()
    {
        $data = $this->getUserData();
        return $data['time_vip'];
    }
	
    public function timeleft($time, $l = 0)
    {
        $days    = floor((float) $time / 60 / 24);
        $hours   = $time / 60 % 24;
        $minutes = $time % 60;
        if ($minutes < 10) {
            $minutes = "0" . $minutes;
        }
        if ($hours < 10) {
            $hours = "0" . $hours;
        }
        $day = $this->days($days);
        if ($l == 1) {
            $day = $this->daysLang($days);
        }
        return $days . " " . $day . " " . $hours . ":" . $minutes;
    }
	
    public function daysLang($d)
    {
        if ($d == 1)
            return "{word_36}";
        if ($d >= 5 && $d <= 20)
            return "{word_37}";
        $x = $d % 10;
        if ($x == 1)
            return "{word_36}";
        if ($x == 2 || $x == 3 || $x == 4)
            return "{word_38}";
        return "{word_37}";
    }
	
    public function days($d)
    {
        if ($d == 1)
            return "день";
        if ($d >= 5 && $d <= 20)
            return "дней";
        $x = $d % 10;
        if ($x == 1)
            return "день";
        if ($x == 2 || $x == 3 || $x == 4)
            return "дня";
        return "дней";
    }
	
    public function isDaily()
    {
        global $mysqli;
        $date = date("Y-m-d");
        $is   = $mysqli->query("SELECT `date` FROM `statistic` WHERE `date` = '{$date}' LIMIT 1");
        if ($is->num_rows == 1) {
            return true;
        }
        return false;
    }
	
    public function redirect($url)
    {
        echo "<meta http-equiv='Refresh' content='0;
 URL={$url}'>";
        exit;
    }
    public function pageNav($nPage, $quantity, $prefix = "")
    {
        $limit         = 10;
        $pages         = ceil($quantity / $limit);
        $first         = "";
        $page5left     = "";
        $page4left     = "";
        $page3left     = "";
        $page2left     = "";
        $page1left     = "";
        $page          = "<span class='light-page-nav'>{$nPage}</span>";
        $page1right    = "";
        $page2right    = "";
        $page3right    = "";
        $page4right    = "";
        $page5right    = "";
        $last          = "";
        $add_class     = "<div id='navigation-page'>";
        $end_add_class = "</div>";
        $uri           = preg_replace("/page(\d)/i", $_SERVER['REQUEST_URI'], "");
        if ($nPage > 3) {
            $first = '';
        }
		
        if ($nPage > 1) {
            $back = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 1) . '" class="dark-page-nav">← Сюда</a>';
        } else {
            $back = '<span class="dark-page-nav disabled-link">← Сюда</span>';
        }
		
        if (($nPage - 5) > 0) {
            $page5left = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 5) . '" class="dark-page-nav">' . ($nPage - 5) . '</a>';
        }
		
        if (($nPage - 4) > 0) {
            $page4left = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 4) . '" class="dark-page-nav">' . ($nPage - 4) . '</a>';
        }
		
        if (($nPage - 3) > 0) {
            $page3left = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 3) . '" class="dark-page-nav">' . ($nPage - 3) . '</a>';
        }
		
        if (($nPage - 2) > 0) {
            $page2left = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 2) . '" class="dark-page-nav">' . ($nPage - 2) . '</a>';
        }
		
        if (($nPage - 1) > 0) {
            $page1left = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage - 1) . '" class="dark-page-nav">' . ($nPage - 1) . '</a>';
        }
		
        if ($nPage < $pages) {
            $page1right = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 1) . '" class="dark-page-nav">' . ($nPage + 1) . '</a>';
        }
		
        if (($nPage + 1) < $pages) {
            $page2right = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 2) . '" class="dark-page-nav">' . ($nPage + 2) . '</a>';
        }
		
        if (($nPage + 2) < $pages) {
            $page3right = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 3) . '" class="dark-page-nav">' . ($nPage + 3) . '</a>';
        }
		
        if (($nPage + 3) < $pages) {
            $page4right = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 4) . '" class="dark-page-nav">' . ($nPage + 4) . '</a>';
        }
		
        if (($nPage + 4) < $pages) {
            $page5right = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 5) . '" class="dark-page-nav">' . ($nPage + 5) . '</a>';
        }
		
        if ($nPage < $pages) {
            $forward = '<a href="' . $prefix . 'page' . $uri . '' . ($nPage + 1) . '" class="dark-page-nav">Туда →</a>';
        } else {
            $forward = '<span class="dark-page-nav disabled-link">Туда →</span>';
        }
		
        if ($nPage < ($pages - 2)) {
            $last = '';
        }
		
        $pn_result = $add_class . $first . $back . $page5left . $page4left . $page3left . $page2left . $page1left . $page . $page1right . $page2right . $page3right . $page4right . $page5right . $forward . $last . $end_add_class;
        if ($pn_result == "<div id='navigation-page'><span class=\"dark-page-nav disabled-link\">← Сюда</span><span class='light-page-nav'>1</span><span class=\"dark-page-nav disabled-link\">Туда →</span></div>")
            $pn_result = "";
        return $pn_result;
    }
	
    public function redirectDelay($url, $delay)
    {
        echo "<script type='text/javascript'>
					window.addEventListener('load', function() {
						setTimeout(function() {
							location.href = '{$url}';
						}, {$delay});
					}, false);
				 </script>";
    }
}
?>