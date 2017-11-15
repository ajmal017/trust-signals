<?php
	class Reg extends Core {
		public function getTitle() {
			echo "TrustSignals - Регистрация";
		}
		public function getContent() {
            $this->changeLauncher("reg");
			$adds = new Additions();
            if(!$adds->isAuth()) {
                global $mysqli;
                
            }
            else {
                $adds->redirect(URI."/cabinet/");
            }
		}
	}
?>