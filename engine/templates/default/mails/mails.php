<div class="col-md-12 mail" id="mail-box-%id%">
    <div class="row">
        <div class="col-md-3 %side% mail-data %color-new%">
            <div class="mails-panel">
                <p><a href="#" data-toggle="modal" data-target="#remove-message" class="remove-message" data-id="%id%"><span class="glyphicon glyphicon-remove-sign"></span> Удалить</a></p>
                <p><a href="#" class="open-message" data-id="%id%"><span class="glyphicon glyphicon-eye-open"></span> Просмотреть</a></p>
            </div>
            <div class="col-md-5 col-xs-4 col-sm-2 mail-img">
                <img src="%photo%">
            </div>
            <div class="col-md-7 col-xs-8 col-sm-10 mail-name">
                <p><span class="glyphicon glyphicon-check"></span> %name%</p>
                <p><span class="glyphicon glyphicon-calendar"></span> %date%</p>
            </div>
        </div>
        <div class="col-md-9 col-xs-12 mail-message open-message" data-id="%id%">
            <span class="glyphicon glyphicon-comment"></span> %message%
        </div>
    </div>
</div>