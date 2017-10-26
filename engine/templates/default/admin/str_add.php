<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Добавить стратегию</h3>
<button class="btn btn-default" id="add-strategy-img"><span class="glyphicon glyphicon-picture"></span> Загрузить картинку</button>
<div class="form-group">
    <label for="exampleInputEmail1">Название стратегии</label>
    <input type="text" class="form-control" id="strategy-title" placeholder="Название стратегии">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Описание к стратегии</label>
    <textarea class="form-control" id="strategy-desc" placeholder="Описание к стратегии" rows="3"></textarea>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Тип стратегии</label>
    <select id="type-of-strategy">
        <option value="vip">VIP</option>
        <option value="cabinet">CABINET</option>
    </select>
</div>
<div class="form-group">
    <button id="add-strategy" class="btn btn-info disabled">Сохранить</button>
</div>
<div class="panel panel-default">
    <div class="panel-body" style="background: #333 !important;">
        <div class="col-md-12" style="padding: 0;"><h4><a style="color: #fff;" href="%URI%/strs/"><span class="glyphicon glyphicon-arrow-left"></span> К списку стратегий</a></h4></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() { CKEDITOR.replace("strategy-desc"); });
</script>