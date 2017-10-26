<div id="tmp-list" style="display: none;">%tmp-list%</div>
<div class="form-group">
    <button class="btn btn-success">Онлайн: %aonline%</button>
    <button class="btn btn-success" id="activate-users">Активировать всех пользователей</button>
    <button class="btn btn-default" id="reload-base">Обновить базу</button>
    <a class="downloadbase" href="%uri%/engine/classes/base/users.xlsx" download><span class="glyphicon glyphicon-download-alt"></span> Скачать XLSX</a>
</div>
<div class="form-group">
    <input type="text" class="form-control" id="search-canvas" placeholder="Поиск" aria-describedby="basic-addon1">
</div>
<table class="table user-list">
    <thead>
    <tr>
        <th><span>Пользователь</span></th>
        <th><span>Регистрация</span></th>
        <th class="text-center"><span>Статус</span></th>
        <th>Email</th>
        <th class="text-center">Управление</th>
    </tr>
    </thead>
    <tbody id="users-content">
            %users%
            <tr>
                <td colspan="5">%page_nav%</td>
            </tr>
    </tbody>
</table>
<div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="send-mess-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="send-label">Настройки</h4>
            </div>
            <div class="modal-body">
                <h4 class="panel-title-window">Информация</h4>
                <p><span class="glyphicon glyphicon-paperclip"></span> Соц. ссылка: <strong id="user-soc-address"></strong></p>
                <p><span class="glyphicon glyphicon-globe"></span> Регистрация из: <strong id="user-from-reg"></strong></p>
                <h4 class="panel-title-window">Изменить E-mail</h4>
                <div class="form-group">
                    <input type="text" class="form-control" id="set-val-email" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="set-btn-email">Изменить</button>
                </div>
                <h4 class="panel-title-window">Изменить пароль</h4>
                <div class="form-group">
                    <input type="text" class="form-control" id="set-val-password" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="set-btn-password">Изменить</button>
                </div>
                <h4 class="panel-title-window">Время в базовом кабинете</h4>
                <p><span class="glyphicon glyphicon-time"></span> <span id="basic-time"></span></p>
                <div class="form-group">
                    <label for="exampleInputEmail1">Установить на: </label>
                    <select id="set-val-timeleft">
                        <option></option>
                        <option value="0">Убрать вовсе</option>
                        <option value="1440">День</option>
                        <option value="2880">Два дня</option>
                        <option value="4320">Три дня</option>
                        <option value="10080">Неделя</option>
                        <option value="20160">Две недели</option>
                        <option value="30240">Три недели</option>
                        <option value="43200">Месяц</option>
                        <option value="86400">Два месяца</option>
                        <option value="129600">Три месяца</option>
                        <option value="518400">Год</option>
                        <option value="1036800">Два года</option>
                        <option value="1555200">Три года</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="set-btn-timeleft">Установить</button>
                    <button class="btn btn-danger" id="add-btn-timeleft">Добавить</button>
                </div>
                <h4 class="panel-title-window">Время в VIP кабинете</h4>
                <p><span class="glyphicon glyphicon-time"></span> <span id="vip-time"></span></p>
                <div class="form-group">
                    <label for="exampleInputEmail1">Установить на: </label>
                    <select id="set-val-time-vip">
                        <option></option>
                        <option value="0">Убрать вовсе</option>
                        <option value="111">+ ROBOT</option>
                        <option value="1440">День</option>
                        <option value="2880">Два дня</option>
                        <option value="4320">Три дня</option>
                        <option value="10080">Неделя</option>
                        <option value="20160">Две недели</option>
                        <option value="30240">Три недели</option>
                        <option value="43200">Месяц</option>
                        <option value="86400">Два месяца</option>
                        <option value="129600">Три месяца</option>
                        <option value="518400">Год</option>
                        <option value="1036800">Два года</option>
                        <option value="1555200">Три года</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="set-btn-time-vip">Установить</button>
                    <button class="btn btn-danger" id="add-btn-time-vip">Добавить</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="send-mess-post" tabindex="-1" role="dialog" aria-labelledby="send-mess-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="send-label">Отправить сообщение на почту</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="disabled-email"><span id="send-title">Сообщение</span></label>
                    <textarea class="form-control" id="send-text-post" placeholder="Введите Ваше сообщение" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="send-btn-post">Отправить</button>
                </div>
                <h2>Шаблоны сообщений</h2>
                <div class="row">
                    <div class="col-md-12" id="templates-posts"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="send-mess" tabindex="-1" role="dialog" aria-labelledby="send-mess-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="send-label">Отправить сообщение</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="disabled-email"><span id="send-title">Сообщение</span></label>
                    <textarea class="form-control" id="send-text" placeholder="Введите Ваше сообщение" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="send-btn">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</div>