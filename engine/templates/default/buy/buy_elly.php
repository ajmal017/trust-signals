<div class="col-md-12">
    <div class="row">
        <div class="col-md-12"></div>
    </div>
    <div id="open-pay-systems">
        <div class="pay-system-item-info">
            <h4><span class="glyphicon glyphicon-credit-card"></span> Сумма к оплате: <strong><span id="systems-summ"></span></strong>$</h4>
            <h4><span class="glyphicon glyphicon-briefcase"></span> Тип пакета: <strong>РОБОТ</strong></h4>
        </div>
        <ul class="text-center nav nav-pills" role="tablist">
            %systems%
        </ul>
        <div class="tab-content" style="z-index: 2;">
            %list_systems%
            <div class="form-group col-md-12 col-sm-12 col-lg-12">
                <button class="btn btn-warning disabled btn-lg" id="generation-link">Оплатить</button>
            </div>
        </div>
    </div>
</div>
<style media="screen">
    .pay-system-item {
        float: none !important;
    }
</style>
<!--  PayPal  -->
<div class="modal fade" id="paypal-system" tabindex="-1" role="dialog" aria-labelledby="paypal-system-label" style="z-index: 500000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через YandexMoney</h4>
            </div>
            <div class="modal-body" id="chart-box-modal" style="height: 100%;">

                <div class="row">
                    <div class="col-md-6" style="    background-color: #E6463A;
	color: white;
	padding: 10px;"><b>Тарифы VIP раздела.</b><br>
                        На 1 неделю -- 1500 рублей <br>
                        На 1 месяц + ROBOT -- 2699 рублей <br>
                        На 1 Год + ROBOT -- 6999 рублей </div>




                    <div class="col-md-6" style="background-color: #009688;
	color: white;
	padding: 10px;"><b>Тарифы базавого раздела.</b><br>
                        3 дня -- 299 рублей <br>
                        7 дней -- 499 рублей <br>
                        30 дней-- 899 рублей </div>

                    <div class="hidden-xs col-md-12" style="margin-top: 10px;">
                        <center style="">
                            <iframe frameborder="0" allowtransparency="true" scrolling="no" style="background: rgba(51, 51, 51, 0.14);"
                                    src="https://money.yandex.ru/embed/shop.xml?account=410015355400036&quickpay=shop&payment-type-choice=on&writer=seller&targets=%D0%9E%D0%BF%D0%BB%D0%B0%D1%82%D0%B0+%D0%B2%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%B8+Option-Signal&default-sum=&button-text=01&comment=on&hint=%D0%A3%D0%BA%D0%B0%D0%B6%D0%B8%D1%82%D0%B5+%D1%81%D0%B2%D0%BE%D0%B9+Email+%D0%B2+%D1%81%D0%B5%D1%80%D0%B2%D0%B8%D1%81%D0%B5&mail=on&successURL=http%3A%2F%2Ftrust-signals.com%2Fpay%2Fpayok.php" width="450" height="268"></iframe>

                        </center>
                    </div>
                    <div style="margin-top: 10px; background-color: rgba(0, 13, 255, 0.74);
	padding: 10px;
	color: white;" class="col-md-12 hidden-sm hidden-md hidden-lg">
                        <p><b>Реквизиты: </b>410015355400036</p>
                        <p>1. Оплатить на сумму выбранного Вами пакета</p>
                        <p>2. Отправить чек с результатом оплаты в техподдержку</p>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через Neteller</h4>
            </div>
            <div class="modal-body" id="chart-box-modal" style="    height: 100%;">




                <div class="row">
                    <div class="col-md-6" style="    background-color: #E6463A;
	color: white;
	padding: 10px;"><b>Тарифы VIP раздела.</b><br>
                        На 1 неделю -- 25$ <br>
                        На 1 месяц + ROBOT-- 45$ <br>
                        На 1 Год + ROBOT -- 99$ </div>




                    <div class="col-md-6" style="background-color: #009688;
	color: white;
	padding: 10px;"><b>Тарифы базавого раздела.</b><br>
                        3 дня -- 299 рублей <br>
                        7 дней -- 499 рублей <br>
                        30 дней-- 899 рублей </div>

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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Оплата через Skrill</h4>
            </div>
            <div class="modal-body" id="chart-box-modal">


                <div class="row">
                    <div class="col-md-6" style="    background-color: #E6463A;
	color: white;
	padding: 10px;"><b>Тарифы VIP раздела.</b><br>
                        На 1 неделю -- 25$ <br>
                        На 1 месяц + Robot -- 45$ <br>
                        На 1 Год + Robot -- 99$ </div>




                    <div class="col-md-6" style="background-color: #009688;
	color: white;
	padding: 10px;"><b>Тарифы базавого раздела.</b><br>
                        3 дня -- 5$ <br>
                        7 дней -- 7$ <br>
                        30 дней -- 15$ </div>

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
