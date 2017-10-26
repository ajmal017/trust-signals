<div class="col-lg-6 col-md-12 user-signal" data-id="%id%" id="user-signal-%id%">
    <div class="col-md-12 title-signal title-signal-%pos%">
        <div class="col-md-7 col-xs-7 col-sm-7 title-symbol">
            <span data-toggle="tooltip" data-placement="top" title="Ставка">
                <span class="glyphicon glyphicon-arrow-%pos%"></span>
            </span>
            <span data-toggle="tooltip" data-placement="top" title="Валютная пара">%symbol%</span>
        </div>
        <div class="col-md-5 col-xs-5 col-sm-5 text-right">
            <div class="col-md-12">
                <span data-toggle="tooltip" data-placement="top" title="Время выхода сигнала">%time% (МСК)</span>
            </div>
            <div class="col-md-12">
                <span data-toggle="tooltip" data-placement="top" title="Время выхода сигнала">%date%</span>
            </div>
        </div>
    </div>
    <div class="col-md-12 user-signal-content">
        <div class="col-md-12 text-center time-exp">
            <span data-toggle="tooltip" data-placement="top" title="Время экспирации">Время экспирации: %time_exp%М</span>
        </div>
        <div class="col-md-12 text-center rate-bar text-center">
            <div class="pie_progress text-center" role="progressbar" data-goal="%interest%">
                <div class="pie_progress__number">0%</div>
            </div>
        </div>
        <div class="col-md-12 user-signal-vote">
            %votes%
        </div>
    </div>
    <div class="col-md-12 user-signal-author user-signal-author-%pos%">
        <div class="col-xs-4 text-left author-photo"><img data-toggle="tooltip" data-placement="right" title="%name%" src="%photo%" alt="ALT"></div>
        <div class="col-xs-8 text-right rank-author">
            <span data-toggle="tooltip" data-placement="left" title="Авторитет пользователя">
                <span class="glyphicon glyphicon-signal"></span> %rank%
            </span>
        </div>
    </div>
</div>