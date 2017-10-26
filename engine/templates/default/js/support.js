$(document).ready(function() {
    $(".clear-history").click(function(e) {
        if(confirm("Очистить историю?")) {
            var me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    "action" : "remove-supp"
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".chat-content").html("");
                        $(".load-more-support").remove();
                        me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                        me.removeClass("label-success").addClass("label-default").removeClass("remove-supp");
                        showMessage("Запись была успешно удалена");
                    }
                    else {
                        showMessage("Произошла ошибка при удалении записи");
                    }
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                }
            });
        }
        e.preventDefault();
        return false;
    });
    /* LOAD */
    var num = 5;
    $(".load-more-support .load-more-information").click(function() {
        $(".load-more-support .load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-supps',
                n : num
            },
            success:function(data){
                if(data == 'empty') {
                    $(".load-more-support .load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".load-more-support .load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".load-more-support .load-more-information .load-text").text("Загрузить ещё");
                    $(".chat-content").append(data);
                    console.log(data);
                    num += 5;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    /* SEND MESSAGE */
    $(".send-message").click(function() {
        $(".send-message").html("Отправить сообщение <span class='glyphicon glyphicon-refresh loader'></span>");
        var subject = $("#subject").val(),
            text = $("#text").val();
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=support",
            data: {
                action: "send",
                "subject": subject,
                "text": text
            },
            success: function(data) {
                $("#subject").val("");
                $("#text").val("");
                $(".send-message").html("Отправить сообщение");

                if(data == 'empty') {
                    showMessage("Заполнения все необходимые поля");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
                else {
                    showMessage("Сообщение было отправлено");
                    if($(".chat-content .chat-box").length == 0) {
                        $(".chat-content").html(data);
                    }
                    else {
                        $(data).prependTo(".chat-content");
                    }
                }
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".send-message").html("Отправить сообщение");
            }
        });
    });
});