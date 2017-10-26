<!-- OPT BASE -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Оптимизация базы</h3>
<button id="base-cleaner" class="btn btn-warning btn-lg">Оптимизация базы <span class="badge">%base_size%</span></button>
<!-- TYPE -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Доступ к ELLY</h3>
<div class="form-group">
    <select id="elly">
        <option value="%elly_val%">%elly_type%</option>
        <option value="0">VIP</option>
        <option value="1">VIP месяц+</option>
    </select>
</div>
<div class="form-group">
    <button class="btn btn-primary elly-save">Сохранить</button>
</div>
<!-- MODER -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Добавить/убрать модератора</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Имя пользователя</label>
    <input type="text" class="form-control" id="rules-moder-name" placeholder="Например, Иван Иванов">
</div>
<div id='find-user-box'>
    <p>Поиск...</p>
</div>
<button class="btn btn-primary add-moder">Дать привилегии</button>
<button class="btn btn-danger remove-moder">Снять привилегии</button>
<!--REMOVE PACKAGE-->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Удалить пакет</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Пакет: </label>
    <div id="packages-list-wrapper">
        <select id="packages-list">
            %packages_list%
        </select>
    </div>
</div>
<button class="btn btn-danger package-remove">Удалить пакет</button>
<!-- ADD PACKAGE -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Добавить пакет</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Стоимость пакета</label>
    <input type="text" class="form-control" id="package-price" placeholder="Например, 15">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Действие пакета </label>
    <select id="package-time">
        <option></option>
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
    <label for="exampleInputEmail1">Тип пакета: </label>
    <select id="package-type">
        <option></option>
        <option value="cabinet">CABINET</option>
        <option value="vip">VIP</option>
    </select>
</div>
<button class="btn btn-primary package-add">Добавить пакет</button>
<!-- KEY -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Настройки ключа</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Ключ</label>
    <input type="text" class="form-control" id="key-name" value="%key_name%" placeholder="Например, A2Qief4">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Кол-во минут на зачисление</label>
    <input type="text" class="form-control" id="key-time" value="%key_time%" placeholder="Например, 30">
</div>
<div class="form-group">
    <button class="btn btn-primary key-save">Сохранить</button>
</div>
<!-- DEMO -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Демо модуль</h3>
<input type="checkbox" class="checkbox-styler" %checked% id="demo" data-label="Начислять тестовое время при первой регистрации">
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Демо модуль ( ВРЕМЯ )</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Кол-во минут на зачисление</label>
    <input type="text" class="form-control" id="amount-time" value="%a_time%" placeholder="Например, 5">
</div>
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Демо модуль для WebElly</h3>
<input type="checkbox" class="checkbox-styler" %web_checked% id="web-demo" data-label="Начислять тестовое время при первой регистрации">
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Демо модуль ( ВРЕМЯ ) для WebElly</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Кол-во минут на зачисление</label>
    <input type="text" class="form-control" id="web-time" value="%web_time%" placeholder="Например, 5">
</div>
<div class="form-group">
    <button class="btn btn-primary web-time-save">Сохранить</button>
</div>
<!-- WORLDS -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Выражения</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Список выражений для отправки сообщений ( указать через | )</label>
    <textarea class="form-control" id="world-list-val" placeholder="">%worlds_list%</textarea>
</div>
<div class="form-group">
    <button class="btn btn-primary worlds-save">Сохранить</button>
</div>
<!-- API KEY -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Настройка API</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Ключ</label>
    <input type="text" class="form-control" id="key-api" value="%key_api%" placeholder="Например, AQh34JyS">
</div>
<div class="form-group">
    <button class="btn btn-primary api-save">Сохранить</button>
</div>
<!-- COURSE -->
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Настройка курса доллара</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Курс доллара к рублям</label>
    <input type="text" class="form-control" id="course-val" value="%course%" placeholder="Например, 60"> <span id="kursrub"></span>   
</div>
<div class="form-group">
    <button class="btn btn-primary course-save">Сохранить</button>
</div>
<script>  
    function show()
    {
        $.ajax({
            url: "/engine/templates/default/admin/kursrub.php",
            cache: false,
            success: function(html){
                $("#kursrub").html(html);
            }
        });
    }

    $(document).ready(function(){
        show();
        setInterval('show()',45000);
    });
</script>
