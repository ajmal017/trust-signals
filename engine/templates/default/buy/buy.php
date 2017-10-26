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
				<!--<div role="tabpanel" class="tab-pane active" id="pay-web">
					<div class="col-md-3 text-center pay-system-item" data-system="robokassa" data-pay-system="qiwi"><img src="%root%/img/pays/qiwi.gif" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="robokassa" data-pay-system="walletone"><img src="%root%/img/pays/w1r.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="robokassa" data-pay-system="elecsnet"><img src="%root%/img/pays/elecsnetwalletr.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="robokassa" data-pay-system="unistream"><img src="%root%/img/pays/w1unimoneyoceanr.gif" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="interkassa" data-pay-system="webmoney"><img src="%root%/img/pays/webmoney.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="other" data-pay-system="yandexmoney"><img src="%root%/img/pays/yandexmoney.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="interkassa" data-pay-system="perfectmoney"><img src="%root%/img/pays/pm.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="interkassa" data-pay-system="okpay"><img src="%root%/img/pays/okpay.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="interkassa" data-pay-system="payeer"><img src="%root%/img/pays/payeer.png" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="other" data-pay-system="skrill"><img src="%root%/img/pays/skrill.jpg" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="other" data-pay-system="neteller"><img src="%root%/img/pays/neteller.jpg" alt=""/></div>
					<div class="col-md-3 text-center pay-system-item" data-system="other" data-pay-system="paypal"><img src="%root%/img/pays/paypal.jpg" alt=""/></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="pay-card">
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="visamastercard"><img src="%root%/img/pays/bankcard.png" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system="liqpay"><img src="%root%/img/pays/liqpay.png" alt=""/></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="pay-banks">
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="alfabank"><img src="%root%/img/pays/alfabank.gif" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="rsb"><img src="%root%/img/pays/russianstandardbankr.gif" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system="privat24"><img src="%root%/img/pays/privat24.png" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system="sberonline"><img src="%root%/img/pays/sberonline.png" alt=""/></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="pay-mobile">
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="mts"><img src="%root%/img/pays/mts.gif" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="beeline"><img src="%root%/img/pays/beeline.gif" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system="megafon"><img src="%root%/img/pays/megaphone.png" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system="tele2"><img src="%root%/img/pays/tele2.png" alt=""/></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="pay-terminal">
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="t-qiwi"><img src="%root%/img/pays/qiwi.gif" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system="t-elecsnet"><img src="%root%/img/pays/terminalselecsnetoceanr.gif" alt=""/></div>
				</div>
				<div role="tabpanel" class="tab-pane" id="pay-other">
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="robokassa" data-pay-system=""><img src="%root%/img/pays/robokassa.png" alt=""/></div>
					<div class="col-md-3 col-sm-1 col-xs-1 text-center pay-system-item" data-system="interkassa" data-pay-system=""><img src="%root%/img/pays/interkassa.png" alt=""/></div>
				</div>-->
				<div class="row col-md-12">
					<div class="col-md-2">
						<div class="form-group">
							<button class="btn btn-success disabled btn-lg" id="generation-link">Оплатить</button>
						</div>
					</div>
					%promocode%
				</div>
			</div>
		</div>
		%content%
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
<div style="overflow-y: auto;" class="modal fade" id="yandex-system" tabindex="-1" role="dialog" aria-labelledby="yandex-system-label" style="z-index: 500000;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-credit-card" aria-hidden="true"></i> Оплата через YandexMoney & Master Card & VISA</h4>
			</div>
			<div class="modal-body" id="chart-box-modal" style="height: 100%;">

			<div class="row">
 

<style>
.payya{padding: 5px;border: solid 4px white;

    background-color: #fbfbfb;}
	.payya:hover {border: solid 5px #009688;
	transition:all 0.3s ease;}
</style>

<div class="hidden-xs col-md-12" style="margin-top: 10px;">
<center style="">
<!--  VIP TARIF  -->
<div class="hidden-xs col-md-12" style="margin-bottom: 10px; margin-top: -10px; font-size: 16px;">Тарифы на <i class="fa fa-diamond" aria-hidden="true"></i> VIP аккаунты</div>
<a href="http://paykasa24.com/payment/go/?transaction=vip7&item=VIP%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%207%20%D0%B4%D0%BD%D0%B5%D0%B9.&amount=1999">
<div class="col-sm-4 payya " style=""><i class="fa fa-diamond" aria-hidden="true"></i> <span style="font-size:16px">Vip</span> аккаунт на 7 дней <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">1999 RUB</span> <span style="color:green;">(35$)</span><br> <b style="color:#8BC34A;">ОПЛАТИТЬ</b></center>
	</div></a>
	
	<a href="http://paykasa24.com/payment/go/?transaction=vip30&item=VIP%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%2030%20%D0%B4%D0%BD%D0%B5%D0%B9.&amount=3420">
<div class="col-sm-4 payya " style=""><i class="fa fa-diamond" aria-hidden="true"></i> <span style="font-size:16px">Vip</span> аккаунт на 30 дней <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">3420 RUB</span> <span style="color:green;">(60$)</span><br> <b style="color:#8BC34A;">ОПЛАТИТЬ</b></center>
	</div></a>
	<a href="http://paykasa24.com/payment/go/?transaction=vip1&item=VIP%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%201%20%D0%93%D0%BE%D0%B4.&amount=5650">
<div class="col-sm-4 payya " style=""><i class="fa fa-diamond" aria-hidden="true"></i> <span style="font-size:16px">Vip</span> аккаунт на 1 ГОД <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">5650 RUB</span> <span style="color:green;">(99$)</span><br> <b style="color:#8BC34A;">ОПЛАТИТЬ</b></center>
	</div></a>
<!--  BASE TARIF  -->


<div class="hidden-xs col-md-12" style=" margin-top: 15px; font-size: 16px;">Тарифы на <i class="fa fa-suitcase" aria-hidden="true"></i> Базовые аккаунты</div>
<div class="hidden-xs col-md-12" style="margin-top: 10px;">




<a href="http://paykasa24.com/payment/go/?transaction=24&item=%D0%91%D0%B0%D0%B7%D0%BE%D0%B2%D1%8B%D0%B9%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%2024%20%D1%87%D0%B0%D1%81%D0%B0.&amount=405">
<div class="col-sm-4 payya " style=""><i class="fa fa-suitcase" aria-hidden="true"></i> <span style="font-size:16px">Базовый</span> аккаунт на 1 день <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">405 RUB</span> <span style="color:green;">(7$)</span><br> <b style="color:color:#FF9800;">ОПЛАТИТЬ</b></center>
	</div></a>

<a href="http://paykasa24.com/payment/go/?transaction=2&item=%D0%91%D0%B0%D0%B7%D0%BE%D0%B2%D1%8B%D0%B9%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%202%20%D0%B4%D0%BD%D1%8F.&amount=570">
<div class="col-sm-4 payya " style=""><i class="fa fa-suitcase" aria-hidden="true"></i> <span style="font-size:16px">Базовый</span> аккаунт на 2 дня <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">570 RUB</span> <span style="color:green;">(10$)</span><br> <b style="color:color:#FF9800;">ОПЛАТИТЬ</b></center>
	</div></a>
	
	
	<a href="http://paykasa24.com/payment/go/?transaction=3&item=%D0%91%D0%B0%D0%B7%D0%BE%D0%B2%D1%8B%D0%B9%20%D0%BA%D0%B0%D0%B1%D0%B8%D0%BD%D0%B5%D1%82%20trust-signals.com%20%D0%BD%D0%B0%203%20%D0%B4%D0%BD%D1%8F.&amount=799">
<div class="col-sm-4 payya " style=""><i class="fa fa-suitcase" aria-hidden="true"></i> <span style="font-size:16px">Базовый</span> аккаунт на 3 дня <br><center> 
   <i class="fa fa-shopping-cart" aria-hidden="true" style="color: grey;
    font-size: 16px;"></i> <span style="font-size: 22px;
    color: #607D8B;">799 RUB</span> <span style="color:green;">(14$)</span><br> <b style="color:color:#FF9800;">ОПЛАТИТЬ</b></center>
	</div></a>
	
	
	

</div>
</center>
</div>

<div class="col-md-12" style="margin-top: 10px; background-color: rgba(244, 67, 54, 0.74);
	padding: 10px;
	color: white;"><p class="text-center">
После проверки платежа администратором, время будет начислено!<br>
After checking the time of payment by the administrator will be credited!</p>
</div>


			</div>

			</div>
		</div>
	</div>
</div>
<!--  Neteller  -->
<div style="overflow-y: auto;" class="modal fade" id="neteller-system" tabindex="-1" role="dialog" aria-labelledby="neteller-system-label" style="z-index: 500000;">
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
На 1 месяц + ROBOT-- 60$ <br>
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


<img src="/engine/templates/default/img/nett.png" style="width: 100%;text-align: center; max-width:570px">

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
<div style="overflow-y: auto;" class="modal fade" id="skrill-system" tabindex="-1" role="dialog" aria-labelledby="skrill-system-label" style="z-index: 500000;">
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
На 1 месяц + Robot -- 60$ <br>
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