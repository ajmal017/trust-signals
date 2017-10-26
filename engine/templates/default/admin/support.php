
<div class="text-right" style="padding-bottom: 10px;"><button class="clear-history btn btn-primary"><span class="glyphicon glyphicon-remove-sign"></span> Очистить историю</button></div>
<table class="table">
    <tbody>
    <tr>
        <th>E-mail</th>
        <th>Тема</th>
        <th>Сообщение</th>
        <th class="text-center" style="width: 180px;">Управление</th>
    </tr>
        %records%
    </tbody>
</table>
<div class="modal fade" id="send-mess-email" tabindex="-1" role="dialog" aria-labelledby="send-mess-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="send-label-email">Отправить сообщение на почту</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="disabled-email"><span id="send-title-email">Сообщение</span></label>
                    <textarea class="form-control" id="send-text-email" placeholder="Введите Ваше сообщение" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="send-btn-email">Отправить</button>
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