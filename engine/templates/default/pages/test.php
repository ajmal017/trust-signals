
<?

$time = time() + 7800 ; /*Настройка текущего времени*/

$timedown = $time - 600; /*Настройка времени прошлого 10 свечей назад*/

echo "$time |";
echo "$timedown |";
$params = array( 
'chartRequest' => array( 
'From' => $timedown, /*Прошлое время*/
'To' => $time, /*Текущае время*/
'Symbol' => "EURUSD", /*Валютная пара*/
'Type' => "M1" /*ТФ свечи варианты  MN, W1, D1, H4, H1, M30, M15, M5, and M1 */
) 
); 
$client = new SoapClient('http://client-api.instaforex.com/soapservices/charts.svc?wsdl'); 

echo '<xmp>'.print_r($client->GetCharts($params), true).'</xmp>';


?>