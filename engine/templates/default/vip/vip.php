<div class="row vip-page">
    <div class="col-md-3 text-center open-settings"><span class="glyphicon glyphicon-cog"></span> Настройки</div>
    <div class="col-md-9 text-left news-append">%news%</div>
</div>
<div class="row">
        <div class="col-md-12">
            %select_signals%
        </div>
    </div>
<div class="row" id="signals-box">%signals%</div>
<!-- SOUND -->
<audio id='audio-vip'>
    <source src='%root%/audio/vip.mp3'>
</audio>
<audio id='audio-news'>
    <source src='%root%/audio/sound.mp3'>
</audio>
<!-- SETTINGS -->
<div class="col-md-5 col-sm-12 col-xs-12 setting-box">
    <div class="col-md-12 power-signal-wrapper">
        <p>Настройка звука: </p>
        <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off" id="news-signals-button"><span class="glyphicon glyphicon-volume-up"></span> Экономические новости</button>
        <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off" id="vip-signals-button"><span class="glyphicon glyphicon-volume-up"></span> VIP сигналы</button>
    </div>
    <div class="col-md-12 text-left power-signal-wrapper-pow power-signal-wrapper">
        <p>Настройка силы сигнала | <a class="info-text-link" data-toggle="modal" href="#info-modal">прочитать обязательно</a></p>
        <input type="text" id="power-of-signals">
    </div>
    <div class="col-md-12 text-left power-signal-wrapper">
        <p id="quotes-vip-list-title">Выбрать валютные пары</p>
        %quotes_list%
		<br>
		<a href="javascript:window.location.reload()">Обновить данные</a>
    </div>
    <div class="col-md-12 power-signal-wrapper">
        <p>Инверсия сигналов: </p>
        <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off" id="inv-switch">Включить инверсию</button> <span style="color:red;">Тестирование!</span>
    </div>
    <div data-toggle="tooltip" data-placement="top" title="Закрыть настройки" class="close-settings"><span class="glyphicon glyphicon-remove-sign"></span> Закрыть</div>
</div>

<!-- MODELS -->
<!-- INFORMATION -->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11">Прочитать обязательно</h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
			
			<div class="alert alert-warning"><b>Внимание!</b> После того как Вы сменили силу сигнала сначала Вы увидите историю сигналов, обращайте внимание на время, разница в минуту допускается.</div>
			<div class="panel panel-info">
			<div class="panel-heading">Определение силы сигнала</div>
			<div class="panel-body">
    <p><b>|</b> Сила сигнала 25% - <b>Минимальная сила сигнала</b>, среднее время выхода таких сигналов от 1-ой до 3-х минут. Рекомендуется
	для тех пользователей,  у которых депозит у брокера не мене 350$, максимальная инвестиция 1-2% от депозита.
	Для достижения профита используйте систему Мартингейла.
</p>

<p><b>|</b> Сила сигнала от 35% до 45% - <b>Средняя сила сигнала</b>, среднее время выхода таких сигналов от 3-х до 8-и минут. Рекомендуется
	для тех пользователей, у которых депозит у брокера не мене 200$, максимальная инвестиция 2% от депозита.
	Для достижения профита используйте систему Мартингейла максимально до четвёртого колена.
</p>


<p><b>|</b> Сила сигнала от 55% до 85% - <b>Высокая сила сигнала</b>, среднее время выхода таких сигналов от 10-и до 30-и минут. Рекомендуется
	для тех пользователей, у которых депозит у брокера не мене 100$, максимальная инвестиция 2% от депозита.
	Для достижения профита используйте систему Мартингейла максимально до третьего колена.
</p>


<p><b>|</b> Сила сигнала 100% - <b>Максимальная сила сигнала</b>, среднее время выхода таких сигналов от 30-и до 55-и минут. Рекомендуется
	для тех пользователей, у которых депозит у брокера не мене 100$, максимальная инвестиция 5% от депозита.
	Для достижения профита используйте график цен.
</p>


  </div>
		<div class="alert alert-warning"><b>Внимание!</b> все сигналы рассчитаны на 4-е минуты, для достижения лучшего результата входить в сделку  рекомендуется на 1-ну минуту.
		</div>	
	</div>
			
			
			
			
			
			
			
			
               
            </div>
        </div>
    </div>
</div>
<!-- OPEN STATS -->
<div class="modal fade" id="stast-signal" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Загрузка...</h4>
            </div>
            <div class="modal-body" style="min-height: 520px;" id="chart-box-modal">
                Загрузка...
            </div>
        </div>
    </div>
</div>
<!-- NEWS -->
<div class="modal fade" id="news-modal" tabindex="-1" role="dialog" aria-labelledby="news-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Экономические новости</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>