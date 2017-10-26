<div class="col-md-3 user-data-profile">
    <div class="col-md-12 user-name">%name%</div>
    <div class="col-md-12 user-status"><span class="glyphicon glyphicon-record"></span> Online</div>
    <div class="col-md-12 user-picture text-center">
        <img src="%user_photo%">
    </div>
    <div class="col-md-12 text-center type-of-account">
        %status%
    </div>
    <div class="col-md-12 text-center load-img">
        <button class="btn btn-danger" id="load-img-button2"><span class="glyphicon glyphicon-picture"></span> Загрузить картинку</button>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 text-center sub-information">
        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
            <p class="profile-sub-data-right-m" data-toggle="tooltip" data-placement="right" title="Если Ваш рейтинг достигнет 70, Вы получите +10% времени от покупки"><span class="glyphicon glyphicon-signal"></span> %rank%</p>
            <p class="profile-sub-data-right-m" data-toggle="tooltip" data-placement="right" title="Ваши публикации сигналов"><span class="glyphicon glyphicon-bullhorn"></span> %published%</p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 text-left">
            <p class="profile-sub-data-left-m" data-toggle="tooltip" data-placement="left" title="Голосов за"><span class="glyphicon glyphicon-thumbs-up"></span> %like%</p>
            <p class="profile-sub-data-left-m" data-toggle="tooltip" data-placement="left" title="Голосов против"><span class="glyphicon glyphicon-thumbs-down"></span> %dislike%</p>
        </div>
    </div>
</div>
<div class="col-md-9" id="profile-wrapper">
    <ul class="nav nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#basic-settings" aria-controls="basic-settings" role="tab" data-toggle="tab">Основная информация</a></li>
        <li role="presentation"><a href="#vip-settings" aria-controls="vip-settings" role="tab" data-toggle="tab"><span id="quotes-description">Настройка VIP кабинета</span></a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="basic-settings">
            <div class="form-group">
			
                <label for="disabled-email">Email адрес <span data-toggle="tooltip" data-placement="bottom" title="Email можно изменить, написав с просьбой в службу поддержки" class="glyphicon glyphicon-info-sign"></span></label>
                <input type="email" id="change-email-value" class="form-control" %disabled_email% value="%email%">
            </div>
            <div class="form-group">
                <label for="disabled-email"><span id="name-description">Изменить имя</span></label>
                <input type="text" class="form-control" id="change-name-value" value="%name%">
                <button class="btn btn-success settings-button btn-change-name">Изменить</button>
            </div>
            <div class="form-group">
                <label for="disabled-email"><span id="soc-description">Изменить адрес соц.страницы</span></label>
                <input type="text" class="form-control" id="change-soc-value" placeholder="%soc%">
                <button class="btn btn-success settings-button btn-change-soc">Изменить</button>
            </div>
            <div class="form-group">
                <label for="disabled-email"><span id="pass-description">Изменить пароль</span></label>
                <input type="password" class="form-control" id="change-pass-value" placeholder="Введите пароль">
                <input type="password" class="form-control" id="change-repeat-pass-value" placeholder="Повторите пароль">
                <button class="btn btn-success settings-button btn-change-pass">Изменить</button>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="vip-settings">%vip_settings%</div>
    </div>
</div>