<?php
class GetBid extends Core {
    public function getTitle() {
        echo "Котировки";
    }
    public function getContent() {
        $this->changeLauncher("getbid");
        $adds = new Additions();
        if(isset($_GET['symbol'])) {
            global $mysqli;
            $date = date("Y-m-d");
            $this->initBasicData();
            $user = $adds->getUserData();
            $symbol = str_replace("-", "/", $adds->siftText($_GET['symbol']));
            //echo $symbol;
            $bids = $mysqli->query("SELECT `bid`, `symbol`, `id` FROM `quotes` WHERE `symbol` = '{$symbol}' ORDER BY `id` DESC LIMIT 10");
            if($bids->num_rows > 0) {
                $list = array();
                $bid = $mysqli->assoc($bids);
                do {
                    $list[] = $bid['bid'];
                }
                while($bid = $mysqli->assoc($bids));
                //print_r($list); // [0] - последняя добавленная в базу
				//алгоритм поиска сигналов
				
				if($list[3] > $list[2] && $list[2] > $list[1] && $list[1] > $list[0]){echo "1"; exit;}
				 else if($list[2] > $list[1] && $list[1] > $list[0]){echo "2";}
				 
				 	else if ($list[3] < $list[2] && $list[2] < $list[1] && $list[1] < $list[0]){echo "2"; exit;}
				 
				else if ($list[2] < $list[1] && $list[1] < $list[0]){echo "1";}
			
				
				else {echo "Сигнал отсутствует" ;}
				//echo $list[2];echo $list[1];echo $list[0];
				// конец алгоритма
            }
            else {
                exit("Not found bids of '{$symbol}' in data base");
            }
        }
        else {
            exit("Not found symbol");
        }
    }
}
?>