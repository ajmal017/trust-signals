<?php






$xml = simplexml_load_file('http://quotes.instaforex.com/get_quotes.php?q=eurusd');
foreach ($xml->item as $item)
foreach ($item->symbol as $symbol)
       

foreach ($item->bid as $bid)
foreach ($item->lasttime as $lasttime)
foreach ($item->change as $change)






$time = time() + 7140 ; /*Настройка текущего времени*/

$timedown = $time - 600; /*Настройка времени прошлого 10 свечей назад*/
$params = array( 
'chartRequest' => array( 
'From' => $timedown, /*Прошлое время*/
'To' => $time, /*Текущае время*/
'Symbol' => "EURUSD", /*Валютная пара*/
'Type' => "M1" /*ТФ свечи варианты  MN, W1, D1, H4, H1, M30, M15, M5, and M1 */
) 
); 
$client = new SoapClient('http://client-api.instaforex.com/soapservices/charts.svc?wsdl'); 



$test = (array)$client->GetCharts($params);
$low0 = $test['GetChartsResult']->Candle[0]->Low;
$low1 = $test['GetChartsResult']->Candle[1]->Low;
$low2 = $test['GetChartsResult']->Candle[2]->Low;
$low3 = $test['GetChartsResult']->Candle[3]->Low;
$low4 = $test['GetChartsResult']->Candle[4]->Low;
$low5 = $test['GetChartsResult']->Candle[5]->Low;
$low6 = $test['GetChartsResult']->Candle[6]->Low;
$low7 = $test['GetChartsResult']->Candle[7]->Low;
$low8 = $test['GetChartsResult']->Candle[8]->Low;
$low9 = $test['GetChartsResult']->Candle[9]->Low;

$High0 = $test['GetChartsResult']->Candle[0]->High;
$High1 = $test['GetChartsResult']->Candle[1]->High;
$High2 = $test['GetChartsResult']->Candle[2]->High;
$High3 = $test['GetChartsResult']->Candle[3]->High;
$High4 = $test['GetChartsResult']->Candle[4]->High;
$High5 = $test['GetChartsResult']->Candle[5]->High;
$High6 = $test['GetChartsResult']->Candle[6]->High;
$High7 = $test['GetChartsResult']->Candle[7]->High;
$High8 = $test['GetChartsResult']->Candle[8]->High;
$High9 = $test['GetChartsResult']->Candle[9]->High;
$closed = $test['GetChartsResult']->Candle[9]->Close;
$date = $test['GetChartsResult']->Candle[9]->Timestamp;
 $min = min($low0, $low1, $low2, $low3, $low4, $low5, $low6, $low7, $low8, $low9);
 $max = max($High0, $High1, $High2, $High3, $High, $High, $High6, $High7, $High8, $High9);




if ($ressult=($closed-$min)/($max-$min)*100){}




if (empty($closed)) {
    echo "обновление данных <i class='fa fa-refresh fa-spin'></i>" ;}

elseif ($ressult>98){$down = rand(81, 89); $up = 100-$down; }

elseif ($ressult>86){$down = rand(71, 80); $up = 100-$down; }

elseif ($ressult>76&&$ressult<85){$up = rand(51, 59); $down = 100-$up; }


elseif ($ressult<31&&$ressult>18){$down = rand(51, 62); $up = 100-$down; }


elseif ($ressult<6&&$ressult>3){$up = rand(71, 79); $down = 100-$up; }


elseif ($ressult<3){ $up = rand(80, 92); $down = 100-$up;}
else {echo "обновление данных <i class='fa fa-refresh fa-spin'></i>" ;}

//$up1 = rand(80, 92);
//$down1 = 100-$up1;

//echo $up;
echo "<div class='progress progress-striped active'><div class= 'progress-bar progress-bar-success' style='width: $up%'>$up % PUT
			<span class='sr-only'></span>
		</div>
		
		<div class='progress-bar progress-bar-danger' style='width: $down%'>$down % CALL
			<span class='sr-only'></span>
		</div></div>"
?>




