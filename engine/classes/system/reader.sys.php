<?php
	class Reader {
		private $_path = "";
		private $_content = "";
		public function __construct($tmp) {
			$this->_path = ROOT."/engine/templates/".$tmp;
		}
		public function view($name) {
			$path = $this->_path."/".$name.".php";
			if(file_exists($path)) {
				$this->_content = file_get_contents($path);
			}
			else {
				throw new Exception(1);
			}
		}
		public function change($point, $value) {
			$this->_content = str_replace("%".$point."%", $value, $this->_content);
		}
		public function show() {
			return $this->_content;
		}
	}
	class R {
		static function read($folder, $file, $array) {
			$tmp = ROOT . "/engine/templates/" . $folder ."/". $file . ".php";
			$tmp = file_get_contents($tmp);
			foreach($array as $key => $value) {
				$tmp = str_replace("%".$key."%", $value, $tmp);
			}
			return $tmp;
		}
	}
?>