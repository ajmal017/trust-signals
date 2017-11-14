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
                        На 1 неделю -- 1499 рублей <br>
                        На 1 месяц + ROBOT -- 2699 рублей <br>
                        На 1 Год -- 6999 рублей </div>




                    <div class="col-md-6" style="background-color: #009688;
	color: white;
	padding: 10px;"><b>Тарифы базавого раздела.</b><br>
                        3 дня -- 299 рублей <br>
                        7 дней -- 499 рублей <br>
                        30 дней -- 899 рублей </div>

                    <div class="hidden-xs col-md-12" style="margin-top: 10px;">
                        <center style="">
                            <iframe frameborder="0" allowtransparency="true" scrolling="no" style="background: rgba(51, 51, 51, 0.14);"
                                    src="https://money.yandex.ru/embed/shop.xml?account=410015355400036&quickpay=shop&payment-type-choice=on&writer=seller&targets=%D0%9E%D0%BF%D0%BB%D0%B0%D1%82%D0%B0+%D0%B2%D1%80%D0%B5%D0%BC%D0%B5%D0%BD%D0%B8+Option-Signal&default-sum=&button-text=01&comment=on&hint=%D0%A3%D0%BA%D0%B0%D0%B6%D0%B8%D1%82%D0%B5+%D1%81%D0%B2%D0%BE%D0%B9+Email+%D0%B2+%D1%81%D0%B5%D1%80%D0%B2%D0%B8%D1%81%D0%B5&mail=on&successURL=http%3A%2F%2Fsite3.loc%2Fpay%2Fpayok.php" width="450" height="268"></iframe>

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
                        На 1 Год + ROBOT-- 99$ </div>




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