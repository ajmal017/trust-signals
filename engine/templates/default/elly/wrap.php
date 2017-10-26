<div>
    <ul class="nav nav nav-pills" role="tablist" style="background: #F9F9F9;
    padding: 5px;">


    <div class='hidden-xs' style='padding: 15px; margin-top: 10px;'>
        <a  href="#" onclick="window.open('http://new.trust-signals.com/caledar.php', 'timeout', 'width=600, height=500 scrollbars=yes'); return false;" class='facebook' style='    padding: 15px 5px;
                color: white;     margin-right: 5px;'>
            <i class='fa fa-calendar'></i> Новости
        </a>

        <a data-toggle="modal" data-symbol="%symbol_lower%" href="#graf-modal" class='google-plus google-plus-graph' style='    padding: 15px 5px;
            color: white;  margin-right: 5px;'>
            <i class='fa fa-bar-chart'></i> График
        </a>

        <a data-toggle="modal" href="#info-modal"class='linkedin' style='    padding: 15px 5px;
                color: white;'>
            <i class='fa fa-info-circle'></i> Инфо
        </a>


    </div>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab1">
            <div class="ui-262">
                <div class="">
                    <!-- UI content -->
                    <div class="block-content" style="padding: 0;margin-top: 14px;">
                        <div class="">
                            %signal%
                        </div>
                    </div>
                </div>
            </div>
            <div class="bs-example" class="indicator-one"> <div>Индикатор силы <span class="select-symbol">%symbol%</span> </div>
                <div class="progress" id="indicator">
                    %indicator%
                </div>
            </div>
            <div class="reswitch" style="padding: 20px; cursor: pointer; color: #333;"><span class="fa fa-toggle-on"></span> Включить автопереключение</div>
            <div class="signals-box">
                %signals_list%
            </div>
            <div class="history">
                %history%
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tab2">2</div>
        <div role="tabpanel" class="tab-pane" id="tab3">3</div>
    </div>
</div>
%models%