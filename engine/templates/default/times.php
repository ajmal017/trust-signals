<?
date_default_timezone_set('Europe/Moscow');
$t = date("m.d.Y | H:i");

$unix= time() ;//- 3600;
//echo $unix;
$u = date("m.d.Y | H:i", $unix);
//echo $u;






$time = date("H:i");
//$time = '00:53';

if ($time > '04:00' && $time < '09:00'  ){
	
echo  "$u | Торговая cессия: Токио";	
}
else if ($time > '09:00' && $time < '12:00'  ){
	
echo "$u | Торговая cессия: Лондон и Токио";	
}

else if ($time > '12:00' && $time < '16:00'  ){
	
echo "$u | Торговая cессия: Лондон";	
}
else if ($time > '16:00' && $time < '18:00'  ){
	
echo "$u | Торговая cессия: Лондон и Нью-Йорк";	
}

else if ($time > '18:00' && $time < '23:59'  ){
	
echo "$u | Торговая cессия: Нью-Йорк";	
}
else {echo "$u | Торговые сессии пока закрыты.";}

?>
