<div class="col-md-12 signal-wrapper signal-wrapper-%pos% signal-%translate%" data-icon="%pos%" data-title="%symbol% | Цена входа: %bid% или %pos_name% | Время истечения сигнала: %time2%" data-id="%id%" data-translate="%translate%">
    <div class="col-md-3">
        <div class="col-md-12 signal-symbol"><span data-toggle="tooltip" data-placement="top" title="Ставка" class="glyphicon glyphicon-arrow-%pos%"></span> <span class="symbol-value" data-toggle="tooltip" data-placement="top" title="Валютная пара">%symbol%</span></div>
        <div class="col-md-12 signal-process">
            <div class="progress" data-toggle="tooltip" data-placement="top" title="Сила сигнала %interest%%">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="%interest%" aria-valuemin="0" aria-valuemax="100">
                    %interest%%
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-left">
        <div class="col-md-12 position-wrapper">Цена входа: <span class="label-%pos%">%bid%</span> или <strong class="pos-name-signal">%pos_name%</strong></div>
        <div class="col-md-12">Время выхода сигнала: </div>
        <div class="col-md-12"><span class="glyphicon glyphicon-calendar"></span> <span class="signal-time-one">%time1%</span></div>
        <div class="col-md-12">Рекомендуемая ставка: <span class="signal-money">%money%</span>$</div>
        <div class="col-md-12">Время истечения сигнала:</div>
        <div class="col-md-12"><span class="glyphicon glyphicon-calendar"></span> <span class="signal-time-second">%time2%</span></div>
        <div class="col-md-12">
            <span class="box-timer"></span>
            <span class="label label-primary" data-toggle="tooltip" data-placement="top" title="Допускается использование мартина">M+</span>
            <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Сигнал имеет силу до 100% ">100%</span>
            <span data-toggle="modal" data-symbol="%symbol%" data-target="#stast-signal" class="label label-warning open-stats" data-title="%translate%"><span class="glyphicon glyphicon-signal"></span></span>
            <span class="label label-%status_color%">%status%</span>
        </div>
    </div>
    <div class="col-md-5 text-left frame-wrapper">
        <iframe class="col-md-12 loadframe text-center" scrolling="no" src="%uri%/chart/%symbol%/" frameborder="0"></iframe>
        <div class="loader-signal"><span class="glyphicon glyphicon-refresh loader"></span> Загрузка</div>
    </div>
</div>