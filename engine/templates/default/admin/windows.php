<h3 class="panel-title"><span class="glyphicon glyphicon-record"></span> Добавить окно</h3>
<div class="form-group">
    <label for="exampleInputEmail1">Название</label>
    <input type="text" class="form-control" id="window-title" placeholder="Имя окна">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Язык</label>
    <input type="text" class="form-control" id="window-lang" placeholder="Например, ru, eng, NOT_RU">
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Кол-во дней</label>
    <select id="window-time">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
    </select>
</div>
<div class="col-md-12 panel-body" style="padding: 30px; margin-bottom: 20px;">
    <div class='content-box content-box-window' data-type="true" data-id="add-window" style="min-height: 20px; margin-bottom: 20px;"><h1>Введите содержимое окна</h1></div>
</div>
<div class="form-group">
    <textarea class="form-control pattern-text window-text-save" id="window-text" data-id="add-window" rows="7">Введите содержимое окна</textarea>
</div>
<div class="form-group">
    <button class="btn btn-default" id="window-add">Добавить</button>
</div>