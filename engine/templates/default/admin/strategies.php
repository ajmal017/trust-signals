<style>
    .hd {
        position: absolute;
        margin-top: -20px;
        margin-left: -15px;
        background-color: rgba(76, 14, 14, 0.46);
        width: 100%;
        height: 100%;
        opacity: 0;
    }

    .hd:hover {
        opacity: 1;
    }
</style>
<div id="cabinet-wrapper">
    <ul class="nav nav-pills" id="tabs-list" role="tablist">
        <li role="presentation" class="active">
            <a href="#eurusd-tab" aria-controls="eurusd-tab" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-film"></span>
                Видео от пользователей
                <span data-toggle="modal" href="#info-modal" class="glyphicon glyphicon-plus-sign" title="Добавить видео"></span>
            </a>
        </li>
        <li role="presentation" class="open-users">
            <a href="#users" aria-controls="users" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-bookmark"></span>
                Стратегии
                <span onclick="location.href = '%URI%/strs_add/';" data-toggle="modal" data-target="#apply-user-signal" data-placement="top" title="Добавить стратегию" class="glyphicon glyphicon-plus-sign apply-user-signal-btn"></span>
            </a>
        </li>    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="eurusd-tab">%videos%</div>
        <div role="tabpanel" class="tab-pane" id="users">%strategies%</div>
    </div>
</div>
<!-- Модельное окно добовления видео -->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span class="glyphicon glyphicon glyphicon-cloud-upload"></span> Добавить видео</h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-film"></span></span>
                    <input type="text" id="a-video-name" class="form-control" placeholder="Название видео">
                </div><br>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-link" ></span></span>
                    <input type="text" id="a-video-url" class="form-control" placeholder="Вставте ссылку на видео YouTube">
                </div>	<br>

                <button class="btn btn-default" id="a-add-video" role="button"><span class="glyphicon glyphicon-plus-sign a-loader-changer" data-toggle="tooltip" title="добавить видео"></span> Добавить видео</button>
                <br><br>
                <div class="alert alert-warning"><b>Внимание!</b> все сигналы рассчитаны на 4-е минуты, для достижения лучшего результата входить в сделку  рекомендуется на 1-ну минуту.
                </div>
            </div>



        </div>
    </div>
</div>
<!-- КОНЕЦ Модельное окно добовления видео -->
<div class="modal fade bs-example-modal-lg" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="img-signal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content m-c-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span id="article-modal">...</span></h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
                <center>
                    <img id="img-modal-full" style="max-width: 850px;" class="text-center" src="" alt=""/>
                </center>
            </div>
        </div>
    </div>
</div>