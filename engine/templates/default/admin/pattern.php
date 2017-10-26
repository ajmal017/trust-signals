<div data-id="%id%" class="panel panel-default faq-box">
    <div class="panel-heading" role="tab" id="heading-%id%">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-%id%" aria-expanded="true" aria-controls="collapse-%id%">
                <span class="glyphicon glyphicon-file"></span> <span class="faq-title" data-id="%id%">%title%</span>
            </a>
        </h4>
    </div>
    <div id="collapse-%id%" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-%id%">
        <div class="panel-body">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class='content-box' data-type="true" data-file="%file%" data-id="%id%" style="min-height: 20px; margin-bottom: 20px;">%message%</div>
                    </div>
                    <div class="form-group">
                        <textarea data-file="%file%" class="form-control pattern-text" data-id="%id%" rows="20">%message%</textarea>
                    </div>
                </div>
            </div>
            <div class="row col-md-12 form-group">
                <button class="btn btn-default pattern-save" data-id="%id%" data-file="%file%">Сохранить</button>
            </div>
        </div>
    </div>
</div>