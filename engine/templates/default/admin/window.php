<div data-id="%id%" class="panel panel-default window-box">
    <div class="panel-heading" role="tab" id="heading-%id%">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-%id%" aria-expanded="true" aria-controls="collapse-%id%">
                <span class="glyphicon glyphicon-question-sign"></span> <span class="window-title" data-id="%id%">%title% [%lang_big%]</span>
                <span class="glyphicon glyphicon-remove window-remove" data-id="%id%"></span>
            </a>
        </h4>
    </div>
    <div id="collapse-%id%" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-%id%">
        <div class="panel-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Название</label>
                <input type="text" class="form-control window-title-save" data-id="%id%" value="%title%" placeholder="Имя окна">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Язык</label>
                <input type="text" class="form-control window-lang-save" data-id="%id%" value="%lang%" placeholder="Например, ru, eng">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Кол-во дней</label>
                <select class="window-time-save" data-id="%id%">
                    <option value="%time%">%time%</option>
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
            <div class="col-md-12" style="padding: 30px 0;">
                <div class='content-box content-box-window' data-type="true" data-file="%file%" data-id="%id%" style="min-height: 20px; margin-bottom: 20px;">%text%</div>
            </div>
            <div class="form-group">
                <textarea class="form-control pattern-text window-text-save" data-id="%id%"  data-id="%id%" rows="20">%text%</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default window-add-save" data-id="%id%">Сохранить</button>
            </div>
        </div>
    </div>
</div>