<?php
	abstract class Core {
		public $_tmp = "default";
		public $_name = "main";
		protected $tmp = "";

        public function initBasicData() {
            global $mysqli;
            $adds = new Additions();
            $user = $adds->getUserData();
            if($adds->isAuth()) {
                if(!empty($user['banned'])) {
                    $adds->redirect("/banned/");
                }
            }
            if($user['group'] == 'admin') {
                $sbar = new Reader("default");
                $sbar->view("admin/sadmin");
                $this->templateEdit("moderation", $sbar->show());
            }
            elseif($user['group'] == 'moder') {
                $sbar = new Reader("default");
                $sbar->view("admin/smoder");
                $this->templateEdit("moderation", $sbar->show());
            }
            else {
                $this->templateEdit("moderation", "");
            }
            $count_supps = $mysqli->query("SELECT DISTINCT `user_id`, `email` FROM `support` WHERE `status` = '0' ORDER BY `id`")->num_rows;
            $this->templateEdit("count_supps", $count_supps);
            $this->templateEdit("email", $user['email']);
            $this->templateEdit("OLD_URI", OLD_URI);
            $this->templateEdit("hash_pass", $user['password']);
            $this->templateEdit("lasttime", $adds->timeleft($adds->getLestTimeCabinet()));
            $this->templateEdit("lasttime_vip", $adds->timeleft($adds->getLestTimeVIP()));
            $this->templateEdit("notification", $adds->getAmountNotification());
            $this->templateEdit("mails", $adds->getAmountMails());
            $this->templateEdit("user_photo", $user['img']);
            $this->templateEdit("lasttime", $adds->getLestTimeCabinet());

            $this->templateEdit("days_signal", "");

            if($_GET['page'] == 'cabinet' || $_GET['page'] == 'vip' || $_GET['page'] == 'elly') {
                $sw = new Reader("default");
                $sw->view("cabinet/switch");
                $sw = $sw->show();
                $this->templateEdit("switch_types", $sw);
            }
            else {
                $this->templateEdit("switch_types", "");
            }

            if($_GET['page'] == 'cabinet' || $_GET['page'] == 'vip' || $_GET['page'] == 'strategies' || $_GET['page'] == 'elly') {
                if((date("l") != "Saturday" && date("l") != "Sunday")) {
                    $this->templateEdit("start_class", "loader-minute");
                }
                else {
                    $this->templateEdit("start_class", "");
                }
            }
            else {
                $this->templateEdit("start_class", "");
            }
        }

		protected function changeTemplate($tmp) {
			$this->_tmp = $tmp;
			$path = ROOT."/engine/templates/". $this->_tmp . "/" . $this->_name . ".php";
			$this->tmp = file_get_contents($path);
			$this->tmp = $this->includes($this->tmp);
		}

        protected function changeLauncher($name) {
            $this->_name = $name;
            $path = ROOT."/engine/templates/". $this->_tmp . "/" . $this->_name . ".php";
            $this->tmp = file_get_contents($path);
            $this->tmp = $this->includes($this->tmp);
        }

		protected function templateEdit($point, $value) {
			$this->tmp = str_replace("%".$point."%", $value, $this->tmp);
		}

		public function __construct() {
			session_start();
		}

		protected function includes($tmp) {
			$path = ROOT."/engine/templates/". $this->_tmp;
			preg_match_all("/\{(.*)\}/", $tmp, $inc);
			$inc = $inc[1];
			foreach ($inc as $value) {
				$inc_path = $path."/".$value;
				if(file_exists($inc_path)) {
					$content = file_get_contents($inc_path);
					$tmp = str_replace("{".$value."}", $content, $tmp);
				}
			}
			return $tmp;
		}

        protected function ifelseCSS($tmp) {
            $path = ROOT."/engine/templates/". $this->_tmp;
            preg_match_all("/<-if css=`(.*)`>(.*)<-end>/", $tmp, $ifls);
            foreach($ifls[0] as $key => $value) {
                if($ifls[1][$key] == URI."/".$_GET['page']."/") {
                    $script = "<link href='{$ifls[2][$key]}' rel='stylesheet' type='text/css'>";
                    $tmp = str_replace($value, $script, $tmp);
                }
                else {
                    $tmp = str_replace($value, "", $tmp);
                }
            }
            return $tmp;
        }

        protected function ifAuth($tmp) {
            $adds = new Additions();
            $path = ROOT."/engine/templates/". $this->_tmp;
            preg_match_all("/<\!\-ifAUTH>(\s*.*\t*\n*)<\!\-end>(\s*.*\t*\n*)<\!\-else>(\s*.*\t*\n*)<\!\-endelse>/", $tmp, $ifls);
            foreach($ifls[0] as $key => $value) {
                $tmp_auth = "";
                if($adds->isAuth()) {
                    $tmp_auth = $ifls[1][$key];
                }
                else {
                    $tmp_auth = $ifls[3][$key];
                }
                $tmp = str_replace($value, $tmp_auth, $tmp);
            }
            return $tmp;
        }

        protected function ifelse($tmp) {
            $path = ROOT."/engine/templates/". $this->_tmp;
            preg_match_all("/<-if address=`(.*)`>(.*)<-end>/", $tmp, $ifls);
            foreach($ifls[0] as $key => $value) {
                if($ifls[1][$key] == URI."/".$_GET['page']."/" || (isset($_GET['admin']) && $ifls[1][$key] == URI."/".$_GET['admin']."/")) {
                    $script = "<script src='{$ifls[2][$key]}'></script>";
                    $tmp = str_replace($value, $script, $tmp);
                }
                else {
                    $tmp = str_replace($value, "", $tmp);
                }
            }
            return $tmp;
        }

		public function getBody() {
			$path = ROOT."/engine/templates/". $this->_tmp . "/". $this->_name .".php";
			if(file_exists($path)) {
				$this->tmp = file_get_contents($path);
				$this->tmp = $this->includes($this->tmp);
				
				ob_start();
				$this->getContent();
				$content = ob_get_clean();

				ob_start();
				$this->getTitle();
				$title = ob_get_clean();

				$root = URI."/engine/templates/".$this->_tmp;

				$this->tmp = str_replace("%uri%", URI, $this->tmp);

                $this->tmp = $this->ifAuth($this->tmp);
                $this->tmp = $this->ifelse($this->tmp);
                $this->tmp = $this->ifelseCSS($this->tmp);

				$this->tmp = str_replace("%title%", $title, $this->tmp);
				$this->tmp = str_replace("%content%", $content, $this->tmp);
				$this->tmp = str_replace("%root%", $root, $this->tmp);
                $res = str_replace("", "", $this->tmp); // newlines off
				echo $res;
			}
			else {
				throw new Exception(0);
			}
		}

		abstract function getContent();
		abstract function getTitle();
	}
?>