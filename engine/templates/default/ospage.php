<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>%title%</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" href="%root%/img/favicon-home.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="%root%/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="%root%/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="%root%/css/osfonts.css">
	<link rel="stylesheet" type="text/css" href="%root%/css/ospage.css">
</head>
<body>
	<section class="wrapper">
		{ospage/header.php}
		<section class="middle">
			<section class="address">
				<div class="address-row">
					<div class="address-home">
						<a href="%uri%"><span class="fa fa-arrow-left"></span> Главная</a>
					</div>
					<div class="row address-content">
						<div class="col-sm-3 col-md-3 address-name">
							<div class="address-page">%page_name%</div>
							<div class="address-desc">%description%</div>
						</div>
						<div class="address-gray">
							%mini%
						</div>
						<div class="col-sm-3 col-md-3 address-arrow address-name">
							<span class="fa fa-arrow-down"></span>
						</div>
					</div>
				</div>
			</section>
			%content%
		</section>
		{ospage/footer.php}
	</section>
	<script type="text/javascript" src="%root%/js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="%root%/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="%root%/js/ospage.js"></script>
</body>
</html>