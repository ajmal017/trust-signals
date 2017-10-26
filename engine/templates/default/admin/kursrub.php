




<?php

 $url = file_get_contents("http://brokers.mafftor.ru/wp-content/themes/broker/currency-pairs.php");

 $arr = json_decode($url); 
//print_r($arr);

 //$arr = json_decode($arr); 
 echo $arr->query->results->rate[6]->Name;
echo $arr->query->results->rate[6]->Bid;
  







?>
