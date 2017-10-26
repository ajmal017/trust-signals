<div style="border: none !important; box-shadow: none;" class="ui-254">
    <!-- Profile window -->
    <div class="ui-window">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3><i class="fa fa-comments-o lblue"></i>&nbsp; Открыт диалог с <strong>%name%</strong> <span class="glyphicon glyphicon-chevron-left"></span> <a href="%uri%/supp/">к списку диалогов</a></h3>
                <!-- Profile chat content -->
                <div style="background: #fff;" class="chat-content" tabindex="5001" style="overflow: hidden; outline: none;">
                    %messages%
                </div>
                <!-- Chatting message input box -->
                <div class="chat-input-box">
                    <div class="input-group">
                        <input type="text" class="send-message-input form-control" placeholder="Ваше уведомление">
                        <span class="input-group-btn">
                            <button data-id="%id%" data-email="%email%" class="send-message-button btn btn-lblue" type="button">Отправить</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>