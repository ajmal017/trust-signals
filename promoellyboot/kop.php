<?
   
  $fpi = fopen("counter.txt", "r"); // Открываем файл в режиме чтения
if ($fpi) 
{
while (!feof($fpi))
{
$mytext = fgets($fpi, 999);
echo  "Осталось копий: $mytext ." ;
}
}
else echo "";

$ss = rand (12, 31);
if ($mytext > 2021){$bb = $mytext - 1;}
else {$bb = $mytext + $ss; echo " добавляю $ss копии(й)";}

//if ($bb < 1995) {$bb + 27;}
//echo "<br/ > "$bb + 5;

 $fp = fopen("counter.txt", "w"); // Открываем файл в режиме записи 
$mmytext = $bb ; // Исходная строка
$test = fwrite($fp, $mmytext); // Запись в файл

fclose($fp); //Закрытие файла*/




?>