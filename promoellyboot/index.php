
<?
if (isset($_GET ["uid"])){
$ref = $_GET ["uid"];}
else
$ref = 2;

?>

<!DOCTYPE html>

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>ELLY BOOT - Робот для автоматической торговли бинарными опционами.</title>
<link rel="stylesheet" href="./font/css/font-awesome.min.css">
	<!-- CSS -->
	<!-- Bootstrap core CSS -->
	<link href="./material/bootstrap.min.css" rel="stylesheet" media="screen">

	<!-- Font Awesome CSS 
	<link href="./material/font-awesome.min.css" rel="stylesheet" media="screen">
-->
	<!-- Animate css -->
	<link href="./material/animate.css" rel="stylesheet">

	<!-- Custom styles CSS -->
	<link href="./material/style.css" rel="stylesheet" media="screen">
<head><script src="https://code.jquery.com/jquery-latest.js"></script>
 <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
</head>
<script src="./material/getscripts2"></script></head>
<body style="zoom: 1; overflow: visible;">

	<!-- Preloader -->

	<div id="preloader" style="display: none;">
		<div id="status" style="display: none;"></div>
	</div>

	<!-- Intro section start -->

	<section class="intro">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="i_header" style="margin-top: -50px;">
						<div class="logo">
							<img src="./material/logo.png" alt="">
						</div>
						<h1 style="
    margin-top: -40px;
">ELLY BooT</h1>
						<p>Торговый интерактивный робот для автоматической торговли бинарными опционами.<br> Торговля с "ELLY BOOT" сделает  любого пользователя  профессиональным трейдером и выведет Ваши доходы на новый уровень. </p>
					</div>

				<h2 style="color:green;">Робот доступен для скачивания!</h2>
					<div class="i_footer">
						<a href="https://trust-signals.com/?aff=<?php echo $ref;?>" class="btn btn-default btn-lg btn-theme" style="box-shadow: 0 0 90px #198EA9;">Я хочу робота ELLY BOOT</a>
					</div>

				</div>
			</div>
		</div>

		<div id="particles-js"><canvas width="1349" height="721" style="width: 100%; height: 100%;"></canvas></div>
	</section>

	<!-- Intro section end -->

	<!-- About section start -->

	<section class="about" style="background-image: url(https://trust-signals.com/engine/templates/default/img/home_new/icons/bg.jpg);
    background-color: #F5F5F5;">
		<div class="container" style="margin-top: -50px;     z-index: 10000000000000000000000;
    position: relative;">
			<div class="row">

				<div class="col-md-12">
					<h2>Результаты / Тесты</h2>
					<div class="header-deveider"></div>
					
					<div class="row">
  
  
  <div class="col-xs-12 col-md-12">
    <ul class="thumbnails">
  <li class="span4">
    <div class="thumbnail">
     <iframe width="100%" height="520px" src="https://www.youtube.com/embed/SUl3_bPnfks?rel=0" frameborder="0" allowfullscreen></iframe>
      <h3>Торговля с  <a href="https://trust-signals.com/ln/41/" target="_blank">Olimp Trade</a></h3>
      <p style="font-size:16px">Прибыль за 30 минут работы составила 30$</p>
    </div>
  </li>
  
</ul>
  </div>
  
  
  <div class="col-xs-12 col-md-12"> <a href="https://trust-signals.com/promoellyboot/SetupEllyBoot.exe" download class="btn btn-default btn-lg btn-themee" style="background: #F44336;
    border: 2px solid rgb(212, 45, 34);"><i class="fa fa-cloud-download "></i> СКАЧАТЬ ELLY BOOT</a>
  </div>
  
  <span style="font-size: 16px; color:red">Внимание! Перед тем, как использовать робота на реальном счёте - протестируйте все функции робота на демо и сообщите нам о всех ошибках!</span>
  <?
  
  $fpi = fopen("counter.txt", "r"); // Открываем файл в режиме чтения
if ($fpi) 
{
while (!feof($fpi))
{
$mytext = fgets($fpi, 999);
//echo "$mytext" ;
}
}
else echo "";

$ss = rand (12, 31);
if ($mytext > 35){$bb = $mytext - 1;}
else {$bb = $mytext + $ss; echo " добавляю $ss копии(й)";}

//if ($bb < 1995) {$bb + 27;}
//echo "<br/ > "$bb + 5;

 $fp = fopen("counter.txt", "w"); // Открываем файл в режиме записи 
$mmytext = $bb ; // Исходная строка
$test = fwrite($fp, $mmytext); // Запись в файл

fclose($fp); //Закрытие файла*/




?>




<!--<div id="eurusd"></div>!-->
 <script>  
        function show()  
        {  
            $.ajax({  
                url: "https://trust-signals.com/promoellyboot/bb.php",
                cache: false,  
                success: function(html){  
                    $("#eurusd").html(html);  
                }  
            });  
        }  
      
        $(document).ready(function(){  
            show();  
            setInterval('show()',600);  
        });  
    </script>  
  
  
  
  
  
</div>
					
					
					
				</div>

			</div>
		</div>
	</section>

	
	
	
	
	
	
	<!-- About section end -->

	<!-- Features section start -->

	<section class="features">
		<div class="container">

			<div class="row">

				<div class="col-md-12 subtitle">
					<h2>Особенности</h2>
					<div class="header-deveider"></div>
					<p class="wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
					Торговый робот 'ELLY BOOT' - единственный робот в своём роде, который имеют функцию защиты депозита от слива.</p>
				</div>

				<div class="col-md-4 col-sm-4 wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">
					<div class="features-item">
						<div class="features-item-icon">
							<i class="fa fa-product-hunt"></i>
						</div>
						<h3>Лояльная цена</h3>
						<p>Мы сделали для наших пользователей максимально низкую цену,
						чтобы даже начинающие трейдеры смогли себе позволить Торгового робота ELLY BOOT. </p>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
					<div class="features-item">
						<div class="features-item-icon">
							<i class="fa fa-bar-chart"></i>
						</div>
						<h3>Максимальный результат</h3>
						<p>Торговый робот ELLY BOOT каждую секунду проводит анализ и
						проверяет сотни сценариев поведения рынка, и на основании полученых данных - открывает сделки.</p>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 wow fadeInRight animated" style="visibility: visible; animation-name: fadeInRight;">
					<div class="features-item">
						<div class="features-item-icon">
							<i class="fa fa-bullhorn"></i>
						</div>
						<h3>Безопасность</h3>
						<p>Торговый робот ELLY BOOT  не требует авторизационные данные от платформы брокера, защита от блокировки аккаунта, 
						так как робот полностью имитирует человека.</p>
					</div>
				</div>

			</div>

		</div>
	</section>
<section class="about" style="background-image: url(https://trust-signals.com/engine/templates/default/img/home_new/icons/bg.jpg);
    background-color: #F5F5F5;">
		<div class="container" style="margin-top: -50px;     z-index: 10000000000000000000000;
    position: relative;">
			<div class="row">

				<div class="col-md-12">
					<h2>Что я получу приобретая робота Elly BooT?</h2>
					<div class="header-deveider"></div>
					
					<div class="row">
					<div class="col-xs-12 col-md-12" style="font-size: 18px;">
					Вы получите робота для автоматической торговли Elly Boot, а так же  - Вы получаете доступ ко всем ресурсам сервиса Option-Signal на 1 месяц. Обратите внимание - только у нас, купленное Вами время, идёт только когда Вы используете сервис!
					
					</div>
					
										<div class="col-xs-12 col-md-12" style="font-size: 22px; color: black;">
										Так же Вы можете наблюдать, как работает интерактивный робот Elly.
										</div>
					
					
  <div class="col-xs-12 col-md-6">
    <ul class="thumbnails">
  <li class="span4">
    <div class="thumbnail">
      <iframe width="100%" height="235" src="https://www.youtube.com/embed/NL7OCPo1ePE?rel=0" frameborder="0" allowfullscreen></iframe>
      <h3>Торговля с <a href="https://trust-signals.com/ln/28/" target="_blank">IQ option</a></h3>
      <p style="font-size:16px">Прибыль за 20 минут работы составила 130$</p>
    </div>
  </li>
  
</ul>
  </div>
  
  
  <div class="col-xs-12 col-md-6">
    <ul class="thumbnails">
  <li class="span4">
    <div class="thumbnail">
     <iframe width="100%" height="235" src="https://www.youtube.com/embed/bRJU7Liif3E?rel=0" frameborder="0" allowfullscreen></iframe>
      <h3>Торговля с  <a href="https://trust-signals.com/ln/34/" target="_blank">Expert Option</a></h3>
      <p style="font-size:16px">Прибыль за 20 минут работы составила 120$</p>
    </div>
  </li>
  
</ul>
  </div>
  
  <div class="col-xs-12 col-md-12"> <a href="https://trust-signals.com/?aff=<?php echo $ref;?>" class="btn btn-default btn-lg btn-themee" style=""><i class="fa fa-credit-card"></i> КУПИТЬ РОБОТА ELLY</a>
  </div>
  <div class="col-xs-12 col-md-12"> <a href="https://trust-signals.com/promoellyboot/SetupEllyBoot.exe" download class="btn btn-default btn-lg btn-themee" style="background: #F44336;
    border: 2px solid rgb(212, 45, 34);"><i class="fa fa-cloud-download "></i> СКАЧАТЬ ELLY BOOT</a>
  </div>
  
  
  
  
</div>
					
					
					
				</div>

			</div>
		</div>
	</section>
	<!-- Features section end -->

	<!-- Footer start -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<div id="subscribe" class="col-md-12 subtitle">
					<!--<h2>Подписаться на новости</h2>-->
					<div class="header-deveider"></div>
					<p class="wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">Помните, что машина думает в сотни раз быстрее чем человек!</p>
				</div>
 <div class="col-xs-12 col-md-12"> <a href="https://trust-signals.com/?aff=<?php echo $ref;?>" class="btn btn-default btn-lg btn-themee" style=""><i class="fa fa-credit-card"></i> КУПИТЬ РОБОТА ELLY</a>
  </div>
  <div class="col-xs-12 col-md-12"> <a href="https://trust-signals.com/promoellyboot/SetupEllyBoot.exe" download class="btn btn-default btn-lg btn-themee" style="background: #F44336;
    border: 2px solid rgb(212, 45, 34);"><i class="fa fa-cloud-download "></i> СКАЧАТЬ ELLY BOOT</a>
  </div>
				<!--<div class="col-md-12">
					<form  style="visibility: visible; animation-name: fadeInUp;"action="http://trust-signals.com/sendmail/?task=subform" method="post" accept-charset="utf-8">
                    <input type="hidden" name="action" value="post">
					<input type="hidden" value="7" name="id_cat[]">
          <input size="30" type="hidden"name="name" value="Пользователь ELLY">
						<div class="form-group subscription-form form-inline wow fadeInUp animated" >
							<label class="sr-only" for="sub-email">Укажите Ваш Email</label>
							<input type="email" id="sub-email" name="email" class="form-control input-box" placeholder="Укажите Ваш Email">
						</div>
						<button type="submit" class="btn btn-default btn-theme" target="_blank"><i class="fa fa-rss"></i> Подписаться </button>
					</form>
					
					
					
					
					
					
					
					
					<div class="subscription-message"></div>
				</div>-->

				<div id="share" class="col-md-12 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
					<ul class="socials-links">
						<li><a href="https://www.youtube.com/channel/UCZxazMv0dLxgXqZWRsGRPiw" target="_blank"><i class="fa fa-youtube"></i></a></li>
						<li><a href="https://vk.com/optionsignal1" target="_blank"><i class="fa fa-vk"></i></a></li>
						
					</ul>
					<p class="copyright">
						© 2016 Все права защищены.
					</p>
				</div>

			</div>
		</div>
	</footer>

	<!-- Footer end -->

	<!-- Javascript files -->
	<!-- jQuery -->
	<script src="./material/jquery-1.11.1.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="./material/bootstrap.min.js"></script>
	<!-- Background slider -->
	<script src="./material/jquery.backstretch.min.js"></script>
	<!-- Count Down - Time Circles  -->
	<script src="./material/TimeCircles.js"></script>
	<!-- WOW - Reveal Animations When You Scroll -->
	<script src="./material/wow.min.js"></script>
	<!-- Smooth scroll -->
	<script src="./material/smoothscroll.js"></script>
	<!-- Particles animation -->
	<script src="./material/particles.min.js"></script>
	<!-- Custom scripts -->
	<script src="./material/custom.js"></script>


<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 600px; width: 1349px; z-index: -999999; position: fixed;"><img src="./material/bg5.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 1349px; height: 899.333px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: -149.667px;"></div>
<script src="https://code.jquery.com/jquery-latest.js"></script>
   
</body></html>