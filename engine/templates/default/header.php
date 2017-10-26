


<!-- Уведомление начло!->
<div class='alert alert-warning fade in' style='margin-bottom: 0px; '>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>
     <strong>Внимание!</strong> Модуль техподдержки временно не работает, все свои вопросы Вы можете отправлять нам на email: <b>support@trust-signals.com</b> .
	  </div><!--!-->

<div class="row header">
    <div class="col-md-3">
        <a href="%uri%/cabinet/"><h3 class="logo"></h3></a>
    </div>
    <div class="col-md-9">
        <div class="row panel-box">
            <div class="col-md-1 text-center author-panel">
                <div class="row">
                    <div class="dropdown">
                        <div class="col-md-12">
                            <div id="drop-author-panel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img onerror="this.src = '%root%/img/admin.jpg';" src="%user_photo%">
                            </div>
                            <ul class="dropdown-menu drop-panel" aria-labelledby="drop-author-panel">
                                <li><a href="%uri%/profile/"><span class="glyphicon glyphicon-user"></span> Профиль</a></li>
                                <li><a href="%uri%/mails/"><span class="glyphicon glyphicon-envelope"></span> Сообщения</a></li>
                                <li><a href="#" data-toggle="modal" data-target="#out-modal"><span class="glyphicon glyphicon-off"></span> Выход</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <a  href="#" data-target="#out-modal" data-toggle="modal" title="Выход" class="col-md-1 text-center session-clean close-signals">
                <span class="glyphicon glyphicon-off" aria-hidden="true" style="color: #FD7979;"></span>
            </a>
            <a href="%uri%/notification/" data-toggle="tooltip" data-placement="bottom" title="Оповещения" class="col-md-1 message-box text-center session-clean">
                <span class="glyphicon glyphicon-bell"></span>
                <span class="badge amount-notification">%notification%</span>
            </a>
            <a href="%uri%/mails/" data-toggle="tooltip" data-placement="bottom" title="Сообщения" class="col-md-1 message-box text-center session-clean mails">
                <span class="glyphicon glyphicon-envelope"></span>
                <span class="badge amount-mails">%mails%</span>
            </a>
            <div class="col-md-2 text-center services-panel">
                <div class="row">
                    <div class="dropdown">
                        <div class="col-md-12">
                            <div id="drop-services-panel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-list-alt"></span> Услуги
                            </div>
                            <ul class="dropdown-menu drop-panel" aria-labelledby="drop-services-panel">
                                <li><a href="%uri%/buy/"><span class="glyphicon glyphicon-shopping-cart"></span> Тарифы</a></li>
                                <li><a href="%uri%/key/"><span class="glyphicon glyphicon-pencil"></span> Ввести ключ</a></li>
                            </ul>
							
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right" style="float: right;">
                <div id="google_translate_element"></div>
            </div>
            <span class='hidden-xs hidden-sm'
			style="position: absolute; top: 5px; right: 5px; width: 430px; color: white;">
			<!-- info!--></span>
        </div>
    </div>
</div>