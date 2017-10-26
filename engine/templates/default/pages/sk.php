
<style>
 .text-typing
{
    width: 40em;
    color:green;
    font-size: 22px;
    font-family: 'Marck Script', cursive;
    white-space:nowrap;
    overflow:hidden;
    -webkit-animation: type 8s steps(50, end);
    animation: type 8s steps(50, end);
}
@keyframes type{
    from { width: 0; }
}
 
@-webkit-keyframes type{
    from { width: 0; }
}
 </style>




<script type="text/javascript">
function timer(){
var obj=document.getElementById('timer_inp');
obj.innerHTML--; if (obj.innerHTML == 0) clearTimeout(w);
    if (obj.innerHTML==0){
        document.write("Время вышло!");
        setTimeout(function(){},1000);
    } else {
        setTimeout(timer,1000);
    }
}
setTimeout(timer,1000);
</script>
<?php




date_default_timezone_set('Europe/Moscow');
$t = date("m.d.Y | H:i");

//Переменные
$simbol= "EUR/USD";



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
$closed0 = $test['GetChartsResult']->Candle[0]->Close;
$date = $test['GetChartsResult']->Candle[9]->Timestamp;
$date0 = $test['GetChartsResult']->Candle[0]->Timestamp;
 $min = min($low0, $low1, $low2, $low3, $low4, $low5, $low6, $low7, $low8, $low9);
 $max = max($High0, $High1, $High2, $High3, $High, $High, $High6, $High7, $High8, $High9);



 								
	
	
	
	// работа с базой
 
 
 $conn = mysql_connect("localhost", "a79325_option", "sexonixxx28259441");
    
    if (!$conn) {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    
    if (!mysql_select_db("a79325_option")) {
        echo "Unable to select mydbname: " . mysql_error();
        exit;
    }
    
    $sql = "SELECT result 
            FROM   elly
           ORDER BY id DESC LIMIT 1; ";

    $result = mysql_query($sql);

    if (!$result) {
        echo "Could not successfully run query ($sql) from DB: " . mysql_error();
        exit;
    }
    
    if (mysql_num_rows($result) == 0) {
        echo "No rows found, nothing to print so am exiting";
        exit;
    }

    // До тех пор, пока в результате содержатся ряды, помещаем их в
    // ассоциативный массив.
    // Заметка: если запрос возвращает только один ряд -- нет нужды в цикле.
    // Заметка: если вы добавите extract($row); в начало цикла, вы сделаете
    //          доступными переменные $userid, $fullname, $userstatus.
    while ($row = mysql_fetch_assoc($result)) {
        $resultbd = $row["result"];
        
    }

 
 
 
 
 //
 
 



 
 
 echo "$resultbd /";
 
 
 


 
 



if ($ressult=($closed-$min)/($max-$min)*100){}
echo (int)"$ressult";

if (empty($closed)) { unset($ressult);
   $napravlenie = "<i class='fa fa-refresh fa-spin'></i>"; $timev = "Ожидаем выход сигнала:"; $ostalos = "переменная пуста";}
elseif ($ressult>98){$textbotom= "Сигнал расчитан от 1 до 3 мин.";
								
								
								$napravlenie = "<i class='fa fa-arrow-down red'></i>"; $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек."; $timev = "Время выхода сигнала:"; $color ="red"; $zvuk = "
								<audio autoplay>
    <source src='/eurusddown.ogg' type='audio/ogg; codecs=vorbis'>
    <source src='/eurusddown.mp3' type='audio/mpeg'>
  
 </audio>";}	
	
elseif ($ressult>76&&$ressult<85&&$resultbd<$ressult){$textbotom= "Сигнал расчитан от 1 до 3 мин."; $napravlenie = "<i class='fa fa-arrow-up green'></i>"; $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек."; $timev = "Время выхода сигнала:"; $color ="green"; $zvuk = "
								<audio autoplay>
    <source src='/eurusdup.ogg' type='audio/ogg; codecs=vorbis'>
    <source src='/eurusdup.mp3' type='audio/mpeg'>
  
 </audio>";}	




        



 


 
 elseif ($ressult<31&&$ressult>18&&$resultbd>$ressult){$textbotom= "Сигнал расчитан от 1 до 3 мин."; $napravlenie = "<i class='fa fa-arrow-down red'></i>"; $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек."; $timev = "Время выхода сигнала:"; $color ="red"; $zvuk = "
								<audio autoplay>
    <source src='/eurusddown.ogg' type='audio/ogg; codecs=vorbis'>
    <source src='/eurusddown.mp3' type='audio/mpeg'>
  
 </audio>";}	

 
 
 
elseif ($ressult<6) {
   $textbotom= "Сигнал расчитан от 1 до 3 мин."; $napravlenie = "<i class='fa fa-arrow-up green'></i>"; $ostalos = "<span class='bottom-text'>Осталось времени до входа: <span id='timer_inp'>12</span> сек."; $timev = "Время выхода сигнала:"; $color ="green"; $zvuk = "
								<audio autoplay>
    <source src='/eurusdup.ogg' type='audio/ogg; codecs=vorbis'>
    <source src='/eurusdup.mp3' type='audio/mpeg'>
  
 </audio>";}	

else { $napravlenie = "<i class='fa fa-refresh fa-spin'></i>"; $timev = "Ожидаем выход сигнала:";    }

								
		$shab = 	"
	<div class='col-md-4 col-sm-6' >
	<div class='ui-item highlight bg-$color'>
	<span class='top-text'>Отслеживание по цене</span>
							
								<div class='plot-chart-1'></div>
								$ostalos
							</div>
						</div>
						<div class='col-md-3 col-sm-6'>
							<div class='ui-item'>
								<!-- Small top text -->
								<span class='top-text'>$timev<br> $t (MSK)</span>
								<!-- Heading -->
								<h3> $simbol $napravlenie <span style='font-size: 12px;'>цена <b>$closed</b></span></h3>
								<span class='bottom-text'> $textbotom</span>	 $zvuk	</div>	</div>		
					
					            <div class='col-md-3  hidden-sm hidden-xs' style='border: 1px dashed;  margin-top: 60px;' ><span > Внимание! если у Вас есть предложение
								по улучшению сервиса свяжитесь с нашими менеджарами.</span></div>  "	;							
														
	echo  $shab;							
								

				
								
	$mysqli = @new mysqli('localhost', 'a79325_option', 'sexonixxx28259441', 'a79325_option');
  $mysqli->query("SET NAMES 'utf8'");
  if (mysqli_connect_errno()) {
    echo "Ошибка при соединении к БД: ".mysqli_connect_error();
	

  }

  

  
 
    
    $mysqli->query("INSERT INTO `elly`(`result`) VALUES ($ressult); ");		

    
		 				
	/* $n = if ($resultbd<$ressult){
	 echo "<p class='text-typing'>цена идёт вверх....</p>";
 }
 else {echo "<p class='text-typing'>цена идёт вниз....</p>";}     */
 							
								
								
								

?>
<!-- UI X -->
		
	
		<!-- Flot JS -->
		<script src="/engine/templates/default/js01/jquery.flot.min.js"></script>
		<!-- Flot JS -->
		<script src="/engine/templates/default/js01/jquery.flot.resize.min.js"></script>
		<!-- Knob JS -->
		<script src="/engine/templates/default/js01/jquery.knob.min.js"></script>
		<!-- Placeholder JS -->
		<script src="/engine/templates/default/js01/placeholder.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="/engine/templates/default/js01/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="/engine/templates/default/js01/html5shiv.js"></script>
	

		<script>
			/* plot js */
					
				$(function() {
					/* Chart data #1 */
					var d1 = [[1, <?echo $High0;?>],[2, <?echo $High1;?>], [3, <? echo $High2;?>], [4, <?echo $High3;?>], [5, <?echo $High4;?>],[6, <?echo $High5;?>], [7, <?echo $High6;?>], [8, <?echo $High7;?>], [9, <?echo $High8;?>], [10, <?echo $closed;?>]];
					

					var options = {
						series: {
						  lines: {
							 show: true, fill: false, lineWidth:2, fillColor: { colors: [ { opacity: 0 }, { opacity: 0}] }
						  },
						  points: {
							 show: true, fill: true, lineWidth:2, radius:2.5, fillColor: "rgba(0,0,0,0.3)"
						  },
						  shadowSize: 0
					   },
						colors :["#fff"],
					   grid: {
						  hoverable: true, color: "#fff", backgroundColor:"rgba(0,0,0,0.0)" ,borderWidth:1, borderColor:"rgba(255,255,255,0.3)", labelMargin:8
					   },
					   xaxis: {
						  show: false,
						  ticks: 12,
						  font: {
								size: 9,
								color: ["#fff"]
							}
					   },
					   yaxis: {
						  ticks: 6,
						  font: {
								size: 9,
								color: ["#fff"]
							}
					   }, 
					   legend: {
						  backgroundOpacity:0,
						  noColumns:2,
						  labelBoxBorderColor: "#fff"
					   }
					};
					
					$.plot(".plot-chart-1", [ {data: d1} ], options);
				
				});
				
				
						
		</script>						
