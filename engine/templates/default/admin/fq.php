<div data-id="%id%" class="panel panel-default faq-box">
    <div class="panel-heading" role="tab" id="heading-%id%">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-%id%" aria-expanded="true" aria-controls="collapse-%id%">
                <span class="glyphicon glyphicon-question-sign"></span> <span class="faq-title" data-id="%id%">%title%</span>
                <span class="glyphicon glyphicon-remove faq-remove" data-id="%id%"></span>
            </a>
        </h4>
    </div>
    <div id="collapse-%id%" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-%id%">
        <div class="panel-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Ответ</label>
                <input type="text" class="form-control faq-question" data-id="%id%" value="%title%" placeholder="Вопрос">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Вопрос</label>
                <textarea class="form-control faq-answer" data-id="%id%" rows="3">%message%</textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-default faq-save" data-id="%id%">Сохранить</button>
            </div>
        </div>
    </div>
</div>