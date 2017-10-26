<div id="cabinet-wrapper">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#eurusd-tab" aria-controls="eurusd-tab" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span> EUR/USD</a></li>
        <li role="presentation"><a href="#gbpusd-tab" aria-controls="gbpusd-tab" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span> GBP/USD</a></li>
        <li role="presentation"><a href="#gbpjpy-tab" aria-controls="gbpjpy-tab" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span> GBP/JPY</a></li>
        <li role="presentation"><a href="#interactive" aria-controls="interactive" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-inbox"></span> Интерактивный зал</a></li>
        <li role="presentation" class="open-users">
            <a href="#users" aria-controls="users" role="tab" data-toggle="tab">
                Сигналы от пользователей
                <span data-toggle="modal" data-target="#apply-user-signal" data-placement="top" title="Добавить сигнал" class="glyphicon glyphicon-plus-sign apply-user-signal-btn"></span>
            </a>
        </li>
        <li role="presentation" data-toggle="tooltip" data-placement="top" title="Настройки сигналов"><a href="#" class="open-settings"><span class="glyphicon glyphicon-cog"></span></a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="eurusd-tab">
            <div id="eurusd">%eurusd%</div>
            <div id="history-eurusd">%history-eurusd%</div>
        </div>
        <div role="tabpanel" class="tab-pane" id="gbpusd-tab">
            <div id="gbpusd">%gbpusd%</div>
            <div id="history-gbpusd">%history-gbpusd%</div>
        </div>
        <div role="tabpanel" class="tab-pane" id="gbpjpy-tab">
            <div id="gbpjpy">%gbpjpy%</div>
            <div id="history-gbpjpy">%history-gbpjpy%</div>
        </div>
        <div role="tabpanel" class="tab-pane" style="margin-top: 20px;" id="interactive">
            <div class="col-md-12 text-center tab-int-room">
                <select id="change-quote">
                    <option></option>
                    <option value="EURUSD">EUR/USD</option>
                    <option value="GBPUSD">GBP/USD</option>
                    <option value="GBPJPY">GBP/JPY</option>
                    <option value="AUDCAD">AUD/CAD</option>
                    <option value="EURGBP">EUR/GBP</option>
        
                    <option value="USDJPY">USD/JPY</option>
                </select>
                <div class="alert alert-info" style="height: 500px; margin-top: 20px;     font-size: 29px;" id="chart-box-val">Выберете валютную пару</div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="users">%users%<div id="users-load-more">%users-load-more%</div></div>
    </div>
</div>
<!-- OVER -->
<div id="window-over" class="window-wrapper">
    <div class="window">
        <div class="window-panel">
            <a href="#window-box" class="window-close"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="window-body">
            <h2 class="text-center">Ваш лимит сигналов был исчерпан</h2>
            <h4 style="margin: 10px;margin-top: 30px;"><span class="glyphicon glyphicon-star"></span> Безлимитные сигналы достпны в <span style="text-transform: uppercase; color: red;">VIP аккаунте</span></h4>
            <h4 style="margin: 10px;margin-bottom: 30px;"><span class="glyphicon glyphicon-star-empty"></span> <span style="color: red; text-transform: uppercase; ">Базовый кабинет</span> ограничивает сигналы</h4>
            <p class="text-center">
                <a href="%uri%/buy/" class="btn btn-success">Купить ещё сигналов</a>
                <a href="%uri%/buy/" class="btn btn-danger">Купить безлимит</a>
            </p>
        </div>
    </div>
</div>
<!-- SPAM -->
<div id="window-box" class="window-wrapper">
    <div class="window">
        <div class="window-panel">
            <a href="#window-box" class="window-close"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
        <div class="window-body">
            %spam_content%
        </div>
    </div>
</div>
<div style="display: none;" id="spam-checker">%spam_checker%</div>
<div style="display: none;" id="spam-days">%spam_days%</div>
<!-- SOUND -->
<audio id='audio-users'>
    <source src='%root%/audio/sound2.mp3'>
</audio>
<audio id='audio-cabinet'>
    <source src='%root%/audio/sound1.mp3'>
</audio>
<!-- SETTINGS -->
<div class="col-md-5 col-sm-12 col-xs-12 setting-box">
    <div class="col-md-12 power-signal-wrapper">
        <p>Настройка звука: </p>
        <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off" id="user-signals-button"><span class="glyphicon glyphicon-volume-up"></span> Сигналы от пользователей</button>
        <button type="button" class="btn btn-danger" data-toggle="button" aria-pressed="false" autocomplete="off" id="basic-signals-button"><span class="glyphicon glyphicon-volume-up"></span> Базовые сигналы</button>
    </div>
    <div class="col-md-12 text-left power-signal-wrapper">
        <p>Настройка силы сигнала <a class="info-text-link" data-toggle="modal" href="#info-modal">прочитать обязательно</a> </p>
        Доступна только для <a href="%uri%/vip/">VIP пользователей</a>
    </div>
    <div data-toggle="tooltip" data-placement="top" title="Закрыть настройки" class="close-settings"><span class="glyphicon glyphicon-remove-sign"></span> Закрыть</div>
</div>


<!-- OPEN STATS -->
<div class="modal fade" id="stast-signal" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Загрузка...</h4>
            </div>
            <div class="modal-body" style="min-height: 530px;" id="chart-box-modal">
                Загрузка...
            </div>
        </div>
    </div>
</div>

<!-- ADD USER SIGNAL -->
<div class="modal fade" id="apply-user-signal" tabindex="-1" role="dialog" aria-labelledby="apply-user-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить сигнал</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="key-title">Время выхода сигнала <span style="float: right; margin-top: -5px; margin-left: 10px;"><input name="autotime" id="auto-reload-time" type="checkbox" data-label="Указать автоматически"></span></label>
                    <input type="text" class="form-control" id="apply-time" placeholder="13:30">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="key-title">Валютная пара</label>
                    <select id="apply-symbol">
                        <option></option>
                        %symbols%
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="key-title">Время экспирации</label>
                    <input type="text" class="form-control" id="apply-time-exp" placeholder="5">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1" class="key-title">Ставка</label>
                    <select id="apply-pos">
                        <option></option>
                        <option value="0">На понижение</option>
                        <option value="1">На повышение</option>
                    </select>
                </div>
                <button class="btn btn-danger apply-user-signal-form"><span class="glyphicon glyphicon-ok"></span> Добавить сигнал</button>
            </div>
        </div>
    </div>
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
            
            <div class="alert alert-warning"><b>Внимание!</b> В базовом кабинете выставлять силу сигнала нельзя эта опция доступна только Vip пользователям, Вы можете только выжидать сигнал с нужной силой.</div>
            <div class="panel panel-info">
            <div class="panel-heading">Определение силы сигнала</div>
            <div class="panel-body">
    <p><b>|</b> Сила сигнала 25% - <b>Минимальная сила сигнала</b>, среднее время выхода таких сигналов от 1-ой до 3-х минут. Рекомендуется
    для тех пользователей,  у которых депозит у брокера не мене 350$, максимальная инвестиция 1-2% от депозита.
    Для достижения профита используйте систему Мартингейла.
</p>

<p><b>|</b> Сила сигнала от 35% до 45% - <b>Средняя сила сигнала</b>, среднее время выхода таких сигналов от 3-х до 8-и минут. Рекомендуется
    для тех пользователей, у которых депозит у брокера не мене 200$, максимальная инвестиция 2% от депозита.
    Для достижения профита используйте систему Мартингейла максимально до четвёртого калена.
</p>


<p><b>|</b> Сила сигнала от 55% до 85% - <b>Высокая сила сигнала</b>, среднее время выхода таких сигналов от 10-и до 30-и минут. Рекомендуется
    для тех пользователей, у которых депозит у брокера не мене 100$, максимальная инвестиция 2% от депозита.
    Для достижения профита используйте систему Мартингейла максимально до третьего калена.
</p>


<p><b>|</b> Сила сигнала 100% - <b>Максимальная сила сигнала</b>, среднее время выхода таких сигналов от 30-и до 55-и минут. Рекомендуется
    для тех пользователей, у которых депозит у брокера не мене 100$, максимальная инвестиция 5% от депозита.
    Для достижения профита используйте график цен.
</p>


  </div>
        <div class="alert alert-warning"><b>Внимание!</b> все сигналы рассчитаны на 4-е минуты, для достижения лучшего результата входить в сделку  рекомендуется на 1-ну минуту.
        </div>  
    </div></div></div></div></div>