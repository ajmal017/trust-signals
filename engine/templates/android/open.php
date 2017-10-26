<?php header("Access-Control-Allow-Origin: *"); ?>
<meta http-equiv="Cache-Control" content="no-cache">
<div class="open-wrapper">
	<div class="open-header">
		<div class="open-logout">
			<span class="fa fa-sign-out"></span>
		</div>
		<img class="open-avatar" src=""></img>
		<div class="open-info">
			<p class="open-title">VIP Кабинет</p>
			<p class="open-time"><span class="fa fa-clock-o"></span> <span class="open-time-var"></span></p>
		</div>
	</div>
	<div data-id='0' class="open-get-news">
      	<span class="fa fa-close"></span>
    	<p></p>
    </div>
	<div class="open-title-signals">Вашы сигналы на валютные пары</div>
	<div class="open-content">
		<span class="fa fa-download"></span> Загрузка
	</div>
	<div class="open-settings">
		<div class="open-title-signals open-link"><span class="fa fa-cog"></span> Настройки</div>
		<div class="open-settings-box">
			<div class="open-set-title"><span class="fa fa-signal"></span> Настройка силы сигнала</div>
			<div class="open-set-percent">0%</div>
			<div class="open-progress-box">
				<div class="open-dec">-</div>
				<div class="open-inc">+</div>
				<div class="open-wrap-progress">
					<div class="open-progress"></div>
				</div>
			</div>
			<div class="open-set-title"><span class="fa fa-volume-up"></span> Настройка звука</div>
			<p class="open-volume"><span class='fa fa-bell-slash'></span> Выключить звук сигналов</p>
			<div class="open-set-title"><span class="fa fa-code-fork"></span> Подключение валютных пар</div>
			<div class="open-pairs">
				<span class="fa fa-download"></span> Загрузка валютных пар
			</div>
		</div>
	</div>
	<div class="open-days days-3">
		<div class="open-days-header">
			<div class="open-days-close days-3"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><i class="fa fa-search"></i> Отслеживание цены</div>
		</div>
		<div class="open-days-content days-3" style="height: auto;">
			<div class="open-select-bid open-select">
				<div data-value="0" class="open-select-active">Выберете валютную пару</div>
				<ul>
					<li data-value="eurusd">EUR/USD</li>
					<li data-value="gbpusd">GBP/USD</li>
					<li data-value="gbpjpy">GBP/JPY</li>
					<li data-value="xauusd">Gold</li>
					<li data-value="euraud">EUR/AUD</li>
					<li data-value="usdjpy">USD/JPY</li>
					<li data-value="usdcad">USD/CAD</li>
					<li data-value="usdchf">USD/CHF</li>
					<li data-value="nzdusd">NZD/USD</li>
					<li data-value="eurchf">EUR/CHF</li>
					<li data-value="eurgbp">EUR/GBP</li>
					<li data-value="gbpchf">GBP/CHF</li>
					<li data-value="audusd">AUD/USD</li>
				</ul>
			</div>
			<div class="open-select-pos open-select">
				<div data-value="0" class="open-select-active">Укажите направление</div>
				<ul>
					<li data-value="up">ВЫШЕ ЧЕМ</li>
					<li data-value="down">НИЖЕ ЧЕМ</li>
				</ul>
			</div>
			<div class="open-form">
				<input class="open-search-bid-price" type="text" value="Укажите цену для отслеживания" />
			</div>
			<div class="open-bid-now-price">Текущая цена <span class="open-search-pair-name">EUR/USD</span>: <span class="open-search-pair-price"><i class="fa fa-refresh"></i> Загрузка...</span></div>
    		<div class="open-search-add">
    			<div class="open-search-add-btn">Добавить</div>
    			<div class="open-search-sound"><i class="fa fa-circle"></i> Выключить оповещения сигналов</div>
   			</div>
			<div class="open-search-view">
				<div class="open-search-header"><i class="fa fa-eye"></i> отслеживаются</div>
				<div class="open-search-list-box">
					<div style="padding: 7px;"><i class="fa fa-plus-circle"></i> Список котировок пуст</div>
				</div>
			</div>
    	</div>
	</div>
	<div class="open-days days-2">
		<div class="open-days-header">
			<div class="open-days-close days-2"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-newspaper-o"></span> Экономические новости</div>
		</div>
		<div class="open-days-content days-2" style="height: auto;">
			<div class="open-days-pair">
				<span class="fa fa-download"></span> Загрузка
			</div>
    	</div>
	</div>
	<div class="open-days days-1">
		<div class="open-days-header">
			<div class="open-days-close days-1"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-calendar"></span> <?=date("Y-m-d")?></div>
		</div>
		<div class="open-days-content days-1">
			<div class="open-days-pair">
				<span class="fa fa-download"></span> Загрузка
			</div>
		</div>
	</div>
	<div class="open-days days-4">
		<div class="open-days-header">
			<div class="open-days-close days-4"><span class="fa fa-close"></span></div>
			<div class="open-days-title"><span class="fa fa-support"></span> Техподдержка</div>
		</div>
		<div class="open-days-content days-4">
			<div class="open-days-pair">
				<div class="form-group">
					<p>Тема:</p>
					<input class="open-support-type"/>
				</div>
				<div class="form-group">
					<p>Вопрос:</p>
					<textarea class="open-support-question"></textarea>
				</div>
				<div class="form-group">
					<button class="open-support-send">Отправить</button>
				</div>
			</div>
		</div>
	</div>
	<div class="open-menu">
		<div class="open-menu-hide"><span class="fa fa-chevron-left"></span></div>
		<div>
			<img class="open-menu-avatar" src=""></img>
		</div>
		<div class="open-status"><span class="fa fa-check-circle"></span> Online</div>
		<ul>
			<li><span class="open-menu-days"><i class="fa fa-signal"></i> Сигналы на конец дня</span></li>
			<li><span class="open-menu-news"><i class="fa fa-newspaper-o"></i> Экономические новости</span></li>
			<li><span class="open-menu-search"><i class="fa fa-search"></i> Отслеживание цены</span></li>
			<li><span class="open-menu-support"><i class="fa fa-support"></i> Техподдержка</span></li>
			<li><span class="open-menu-shop"><i class="fa fa-shopping-cart"></i> Оплата услуг</span></li>
			<li><span class="open-menu-logout"><i class="fa fa-sign-out"></i> Выход</span></li>
		</ul>
	</div>
	<div class="open-window">
		<div class="open-window-header"><span class="open-window-close fa fa-close"></span> <span class="open-window-title"><span class="fa fa-download"></span> Загрузка</span></div>
		<div class="open-window-content" id="open-window-content">
			<span class="fa fa-download"></span> Загрузка
		</div>
	</div>
	<div class="open-window-dark">
		<div class="open-window-header-dark"><span class="open-window-close-dark fa fa-close"></span> <span class="open-window-title-dark"><span class="fa fa-download"></span> Загрузка</span></div>
		<div class="open-window-content-dark" id="open-window-content-dark">
			<span class="fa fa-download"></span> Загрузка
		</div>
	</div>
</div>