<!DOCTYPE html>
<html>
<head>
	<title>%title%</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="%root%/img/favicon-home.png">
    <link href="%root%/css/bootstrap.min.css" rel="stylesheet">
	<link href="%root%/css/font-awesome.min.css" rel="stylesheet">
	<link href="%root%/css/checkbox.css" rel="stylesheet">
	<link href="%root%/css/reg.css" rel="stylesheet">
    <link href="%root%/css/buy.css" rel="stylesheet">
</head>
<body>
	<div class="header">СПИСОК ПАКЕТОВ</div>
	<div id="reg">
		<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12"></div>
        </div>
        <div id="open-pay-systems">
            <div class="pay-system-item-info">
                <h4><span class="glyphicon glyphicon-credit-card"></span> Сумма к оплате: <strong><span id="systems-summ"></span></strong>$</h4>
                <h4><span class="glyphicon glyphicon-briefcase"></span> Тип пакета: <strong><span id="systems-type"></span></strong></h4>
            </div>
            <ul class="nav nav-pills" role="tablist">
                %systems%
            </ul>
            <div class="tab-content" style="z-index: 2;">
                %list_systems%
            </div>
        </div>
        %content%
    </div>
</div>
</div>
<style media="screen">
	.pay-system-item {
		display: block;
		float: none !important;
	}
</style>
<!--  GET  -->
<div class="modal fade" id="order-pay" tabindex="-1" role="dialog" aria-labelledby="paypal-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Подтвердить оплату</h4>
            </div>
            <div class="modal-body">
                <div class="pay-system-item-info">
                    <h4><span class="glyphicon glyphicon-credit-card"></span> Сумма к оплате: <strong><span class="systems-summ"></span></strong>$</h4>
                    <h4><span class="glyphicon glyphicon-briefcase"></span> Тип пакета: <strong><span class="systems-type"></span></strong></h4>
                </div>
                <button class="btn btn-success btn-lg" id="generation-link">Оплатить</button>
                <button class="btn btn-default btn-lg" style="margin-top: 10px;" data-dismiss="modal" aria-label="Close">Отмена</button>
            </div>
        </div>
    </div>
</div>
<!--  PayPal  -->
<div class="modal fade" id="paypal-system" tabindex="-1" role="dialog" aria-labelledby="paypal-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через PayPal</h4>
            </div>
            <div class="modal-body" id="chart-box-modal">
                Оплата через PayPal в разработке
            </div>
        </div>
    </div>
</div>
<!--  YandexMoney  -->
<div class="modal fade" id="yandex-system" tabindex="-1" role="dialog" aria-labelledby="yandex-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через YandexMoney</h4>
            </div>
            <div class="modal-body" id="chart-box-modal" style="height: 100%;">

            <div class="row">
  <div class="col-md-6" style="    background-color: #E6463A;
    color: white;
    padding: 10px;"><b>Тарифы VIP раздела.</b><br>
На 1 неделю -- 2450 рублей <br>
На 1 месяц -- 3500 рублей <br>
На 1 Год -- 6999 рублей </div>




  <div class="col-md-6" style="background-color: #009688;
    color: white;
    padding: 10px;"><b>Тарифы базавого раздела.</b><br>
24 часа -- 495 рублей <br>
48 часов -- 615 рублей <br>
72 часа -- 999 рублей </div>

<div class="col-md-12" style="margin-top: 10px;">
<center style="">
<iframe frameborder="0" allowtransparency="true" scrolling="no" style="background: rgba(51, 51, 51, 0.14);"
src="https://money.yandex.ru/embed/shop.xml?account=410011338440103&quickpay=shop&payment-type-choice=on&writer=seller&targets=%D0%9E%D0%BF%D0%BB%D0%B0%D1%82%D0%B0+%D0%B2%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%B8+Option-Signal&default-sum=&button-text=01&comment=on&hint=%D0%A3%D0%BA%D0%B0%D0%B6%D0%B8%D1%82%D0%B5+%D1%81%D0%B2%D0%BE%D0%B9+Email+%D0%B2+%D1%81%D0%B5%D1%80%D0%B2%D0%B8%D1%81%D0%B5&mail=on&successURL=http%3A%2F%2Ftrust-signals.com%2Fpay%2Fpayok.php" class="ymoney" width="450" height="268"></iframe>

</center></div>
<div class="col-md-12" style="margin-top: 10px; background-color: rgba(244, 67, 54, 0.74);
    padding: 10px;
    color: white;"><center>
После проверки платежа администратором, время будет начислено!<br>
After checking the time of payment by the administrator will be credited!</center>
</div>



</div>




            </div>
        </div>
    </div>
</div>
<!--  Neteller  -->
<div class="modal fade" id="neteller-system" tabindex="-1" role="dialog" aria-labelledby="neteller-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через Neteller</h4>
            </div>
            <div class="modal-body" id="chart-box-modal" style="    height: 100%;">




                    <div class="row">
  <div class="col-md-6" style="    background-color: #E6463A;
    color: white;
    padding: 10px;"><b>Тарифы VIP раздела.</b><br>
На 1 неделю -- 35$ <br>
На 1 месяц -- 50$ <br>
На 1 Год -- 99$ </div>




  <div class="col-md-6" style="background-color: #009688;
    color: white;
    padding: 10px;"><b>Тарифы базавого раздела.</b><br>
24 часа -- 7$ <br>
48 часов -- 10$ <br>
72 часа -- 14$ </div>

        <div class="col-md-12" style="margin-top: 10px; font-size: 15px;
    background: rgba(255, 200, 0, 0.28);">
Для оплаты тарифа, переводите нужную сумму на Email: pay@trust-signals.com <br>
To pay for the fare , transfer the required amount to Email: pay@trust-signals.com
</div>

<div class="col-md-12" style="margin-top: 10px;">


<img src="/engine/templates/default/img/nett.png" style="width:570px">

</div>


        <div class="col-md-12" style="margin-top: 10px; background-color: rgba(244, 67, 54, 0.74);
    padding: 10px;
    color: white;"><center>
После проверки платежа администратором, время будет начислено!<br>
After checking the time of payment by the administrator will be credited!</center>
</div>




            </div>
        </div>
    </div>
</div>
</div>
<!--  Skrill  -->
<div class="modal fade" id="skrill-system" tabindex="-1" role="dialog" aria-labelledby="skrill-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через Skrill</h4>
            </div>
            <div class="modal-body" id="chart-box-modal">


                 <div class="row">
  <div class="col-md-6" style="    background-color: #E6463A;
    color: white;
    padding: 10px;"><b>Тарифы VIP раздела.</b><br>
На 1 неделю -- 35$ <br>
На 1 месяц -- 50$ <br>
На 1 Год -- 99$ </div>




  <div class="col-md-6" style="background-color: #009688;
    color: white;
    padding: 10px;"><b>Тарифы базавого раздела.</b><br>
24 часа -- 7$ <br>
48 часов -- 10$ <br>
72 часа -- 14$ </div>

        <div class="col-md-12" style="margin-top: 10px; font-size: 15px;
    background: rgba(255, 200, 0, 0.28);">
Для оплаты тарифа, переводите нужную сумму на Email: pay@trust-signals.com <br>
To pay for the fare , transfer the required amount to Email: pay@trust-signals.com
</div>



        <div class="col-md-12" style="margin-top: 10px; background-color: rgba(244, 67, 54, 0.74);
    padding: 10px;
    color: white;"><center>
После проверки платежа администратором, время будет начислено!<br>
After checking the time of payment by the administrator will be credited!</center>
</div>






            </div>
        </div>
    </div>
</div>
	</div>
	<script src="%root%/js/jquery.min.js"></script>
	<script src="%root%/js/bootstrap.min.js"></script>
	<script src="%root%/js/jquery-ui.js"></script>
	<script src="%root%/js/wow.min.js"></script>
    <script src="%root%/js/checkbox.min.js"></script>
	<script src="%root%/js/buy.js"></script>
	<script src="%root%/js/home_new.js"></script>
</body>
</htm