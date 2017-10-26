<link href="https://fonts.googleapis.com/css?family=Jura:700" rel="stylesheet">
<script src="http://yastatic.net/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  window.onload = function () {
      jQuery("#user-city").text(ymaps.geolocation.city);
  }
</script>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>

<STYLE>
#krestik{color: #ffffff;
    cursor: pointer;
    position: absolute;
    margin: -17 315;
    font-family: sans-serif;
    font-size: 12px;
    background-color: rgb(244, 67, 54);
    padding: 2 8;
    border-radius: 12px 0px;}
	#krestik:hover{background-color: rgb(232, 96, 86);}
</STYLE>

<?
if (($_COOKIE['timer']) == true  )   
{   
$dis = "display:none";
}

?>

<script type="text/javascript">
function openbox(timer){
	var date = new Date(new Date().getTime() + 172800 * 1000);
document.cookie = "timer=value; path=/; expires=" + date.toUTCString();
display = document.getElementById(timer).style.display;
if(display=='none'){
document.getElementById(timer).style.display='block';
}else{
document.getElementById(timer).style.display='none';
 }
}
</script>


<div id="timer" style="width: 350px; width: 350px; <?echo "$dis"?>; background-color: #2b303a; padding: 10px 25px; ">
<div id="krestik" onclick="openbox('timer'); return false" >закрыть</div>
<div style="color: rgb(176, 226, 117); font-family: 'Jura', sans-serif;    padding-bottom: 8px;">
¬ашему городу <span id="user-city" style="color:#00BCD4"></span> cегодн¤ доступна скидка на торгового робота!</div>
<div>
<script src="http://megatimer.ru/s/c3f184010c7dd064ddbf4139caf60549.js"></script>

</div>
<div style="color: rgb(0, 188, 212); font-family: 'Jura', sans-serif;    padding-top: 8px;">
<center>BONUS код на скидку 15%</center></div>
<div style="color: rgb(255, 255, 255); cursor:pointer;    font-size: 26px; font-family: 'Jura', sans-serif;    padding-top: 8px;">
<center>BOnUS152017U</center></div>
<center style="    font-size: 10px;
    color: #8c8c8c;
    font-family: sans-serif;">Cкопируйте код и вставьте его в нужное поле при оплате.</center>
<div>

</div>
