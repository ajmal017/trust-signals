<?php
class Chart extends Core {
    public function getTitle() {}
    public function getContent() {
        $this->changeLauncher("chart");
        $adds = new Additions();
        $date = date("Y-m-d");
        global $mysqli;
        if(isset($_GET['symbol'])) {
            $symbol = $adds->siftText($_GET['symbol']);
            $res = $mysqli->query("SELECT `lasttime`, `bid`, `id` FROM `quotes` WHERE `symbol` = '{$symbol}' ORDER BY `id` DESC LIMIT 20");            if($res->num_rows == 20) {
                $result = array();
                $array_signals = array();
                $row = $res->fetch_assoc();
                do
                {
                    $array_signals[] = $row;
                }
                while($row = $res->fetch_assoc());

                $time = gmdate("H:i", $array_signals[0]["lasttime"]);

                for($i = 0; $i < count($array_signals); $i+=4) {
                    $index = $i;
                    if($index != 0)
                        $index /= 4;
                    $result[$index][0] = $time;
                    $result[$index][1] = (float)$array_signals[$i]["bid"];
                    $result[$index][2] = (float)$array_signals[$i+1]["bid"];
                    $result[$index][3] = (float)$array_signals[$i+2]["bid"];
                    $result[$index][4] = (float)$array_signals[$i+3]["bid"];
                    $time = date('H:i', strtotime("+12 minutes", strtotime($time)));
                }

               $mark1 = '\''.$result[0][0]."',".$result[0][1].",".$result[0][2].",".$result[0][3].",".$result[0][4];
               $mark2 = '\''.$result[1][0]."',".$result[1][1].",".$result[1][2].",".$result[1][3].",".$result[1][4];
               $mark3 = '\''.$result[2][0]."',".$result[2][1].",".$result[2][2].",".$result[2][3].",".$result[2][4];
               $mark4 = '\''.$result[3][0]."',".$result[3][1].",".$result[3][2].",".$result[3][3].",".$result[3][4];
               $mark5 = '\''.$result[4][0]."',".$result[4][1].",".$result[4][2].",".$result[4][3].",".$result[4][4];
               $this->templateEdit("mark1", $mark1);
               $this->templateEdit("mark2", $mark2);
               $this->templateEdit("mark3", $mark3);
               $this->templateEdit("mark4", $mark4);
               $this->templateEdit("mark5", $mark5);
            }
            else {
                $this->templateEdit("mark1", "0, 0, 0, 0, 0");
                $this->templateEdit("mark2", "0, 0, 0, 0, 0");
                $this->templateEdit("mark3", "0, 0, 0, 0, 0");
                $this->templateEdit("mark4", "0, 0, 0, 0, 0");
                $this->templateEdit("mark5", "0, 0, 0, 0, 0");
            }
        }
        else {
            $this->templateEdit("mark1", "0, 0, 0, 0, 0");
            $this->templateEdit("mark2", "0, 0, 0, 0, 0");
            $this->templateEdit("mark3", "0, 0, 0, 0, 0");
            $this->templateEdit("mark4", "0, 0, 0, 0, 0");
            $this->templateEdit("mark5", "0, 0, 0, 0, 0");
        }
    }
}
?>