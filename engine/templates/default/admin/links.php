<h3 class="text-center title-add-link panel-title"><span class="glyphicon glyphicon-record"></span> Добавить ссылку</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Адрес</label>
    <input type="text" class="form-control" id="link-address" placeholder="%URI%">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Описание</label>
    <input type="text" class="form-control" id="link-description" placeholder="trust-signals.com">
</div>
<div class="form-group">
    <button class="btn btn-primary" id="link-add">Добавить</button>
</div>
<table class="table">
    <tbody>
    <tr id="links-list">
        <th>Ссылка</th>
        <th>Перелинковка</th>
        <th>Описание</th>
        <th>Кол-во просмотров</th>
        <th>Кол-во оплат</th>
        <th class="text-center">Управление</th>
    </tr>
    %links%
    </tbody>
</table>