<div class="form-group">
    <input type="text" class="form-control" id="search-canvas-orders" placeholder="Поиск" aria-describedby="basic-addon1">
</div>
<table class="table">
    <thead>
    <tr>
        <th><span>ID</span></th>
        <th><span>ДАТА</span></th>
        <th><span>EMAIL</span></th>
        <th class="text-left"><span>СТАТУС</span></th>
        <th class="text-left"><span>СУММА</span></th>
        <th class="text-center">Управление</th>
    </tr>
    </thead>
    <tbody id="orders-list">
        %orders%
        <tr>
            <td colspan="5">%page_nav%</td>
        </tr>
    </tbody>
</table>
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