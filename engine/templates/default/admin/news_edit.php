<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Изменить картинку</h3>
<button data-id="%id%" class="btn btn-default" id="load-img-news"><span class="glyphicon glyphicon-picture"></span> Загрузить картинку</button>
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Основная информация</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Название стратегии</label>
    <input type="text" class="form-control" id="edit-news-title" value="%title%">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Описание к стратегии</label>
    <textarea class="form-control" id="edit-news-desc" rows="3">%description%</textarea>
</div>
<div class="form-group">
    <button data-id="%id%" id="edit-news" class="btn btn-info">Сохранить</button>
</div>
<div class="panel panel-default">
    <div class="panel-body" style="background: #333 !important;">
        <div class="col-md-12" style="padding: 0;"><h4><a style="color: #fff;" href="%URI%/nws/"><span class="glyphicon glyphicon-arrow-left"></span> К списку новостей</a></h4></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() { CKEDITOR.replace("edit-news-desc"); });
</script>