<?php
	class Remember extends Core {
		public function getTitle() {
			echo "TrustSignals - ВОССТАНОВЛЕНИЕ ПАРОЛЯ";
		}
		public function getContent() {
            $this->changeLauncher("remember");
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