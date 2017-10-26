<?php
	class Form {
		private $ob_obj;

		public function __construct($tmp) {
			$this->ob_obj = new Reader($tmp);
		}
		public function input($type = "", $name = "", $value = "", $id = "", $class_box = "", $adds = "") {
			$ob_obj = $this->ob_obj;
			$ob_obj->view("forms/input");
			$ob_obj->change("value", $value);
			$ob_obj->change("name", $name);
			$ob_obj->change("id", $id);
			$ob_obj->change("class", $class_box);
			$ob_obj->change("type", $type);
			$ob_obj->change("additions", $adds);
			return $ob_obj->show();
		}
	}
?>