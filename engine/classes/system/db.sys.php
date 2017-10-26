<?php
	class db {
		const HOST = DB_HOST;
		const USER = DB_USER;
		const PASSWORD = DB_PASSWORD;
		const BASE = DB_BASE;
		
		private $_db;
		
		private static $_mysqli = null;
		
		private function __construct() {
			
			$mysqli = @new mysqli(self::HOST, self::USER, self::PASSWORD, self::BASE);
			
			if(!$mysqli->connect_error) {
				$this->_db = $mysqli;
				$this->_db->query("SET NAMES 'UTF8'");
				return $mysqli;
			}
			else {
				throw new Exception(4);
			}
			
			
		}
		
		public static function getObject() {
			$ms = self::$_mysqli;
			if($ms == null) {
				$base = new db();
				$ms = $base;
			}
			if(!mysqli_connect_errno()) {
				return $ms;
			}
		}
		
		public function assoc($result) {
			if($result) {
				$rows = $result->fetch_assoc();
				if($rows) {
					return $rows;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		
		public function query($sql) {
			$arg = func_get_args();
				if(count($arg) > 0) {
				$mysqli  = db::getObject();
				for($i = 1; $i < count($arg); $i++) {
					$clear_arg = trim($this->_db->real_escape_string($arg[$i]));
					
					$sql = str_replace("%item".$i."%", $clear_arg, $sql);
					
				}
				
				$result = $this->_db->query($sql);
				
				if($result) {
					return $result;
				}
				else {
					return false;
				}
				
			}
			else {
				throw new Exception(3);
			}
		}
		
	}
?>