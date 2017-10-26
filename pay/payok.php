<?php
header("Refresh: 12; url=https://trust-signals.com/");

$adminemail="support@trust-signals.com";  // e-mail админа
 
 
$date=date("d.m.y"); // число.месяц.год 
 
$time=date("H:i"); // часы:минуты:секунды 

// Отправляем письмо админу  
 
mail("$adminemail", "$date $time mesage 
Proverka Yandeksa", "Schot byl popolnen $date $time"); 
 ?>


<!DOCTYPE HTML>
<!--
	Aerial 1.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Спасибо за оплату..</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
			<link rel="stylesheet" href="css/style-noscript.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body class="loading">
		<div id="wrapper">
			<div id="bg"></div>
			<div id="overlay"></div>
			<div id="main">

				<!-- Header -->
					<header id="header">
						<h1>Спасибо платёж принят</h1>
						<p>После проверки платежа администратором время будет начислено!</p>
						<p>After checking the time of payment by the administrator will be credited!</p>
						<nav>
							<ul>
								<li><a href="#" class="fa fa-twitter"><span>Twitter</span></a></li>
								<li><a href="#" class="fa fa-facebook"><span>Facebook</span></a></li>
								<li><a href="#" class="fa fa-dribbble"><span>Dribbble</span></a></li>
								<li><a href="#" class="fa fa-github"><span>Github</span></a></li>
								<li><a href="#" class="fa fa-envelope-o"><span>Email</span></a></li>
							</ul>
						</nav>
					</header>

				<!-- Footer -->
					<footer id="footer">
						<span class="copyright">© trust-signals.com. <a href="http://trust-signals.com" target="_blank">Лучшие сигналы</a>  <a href="#">OS</a>.</span>
					</footer>
				
			</div>
		</div>
	</body>
</html>