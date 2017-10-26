

<? $fpi = fopen("counter.txt", "r"); // Открываем файл в режиме чтения
if ($fpi) 
{
while (!feof($fpi))
{
$mytext = fgets($fpi, 999);
if ($mytext > 350){
echo  "Осталось копий: <span style='color:green'>$mytext</span> ." ;}
else {echo  "Осталось копий: <span style='color:red'>$mytext</span> ." ;}
}
}
?> 