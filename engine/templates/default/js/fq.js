$(document).ready(function() {
    /* REMOVE */
    $("body").on("click", ".faq-remove", function(e) {
        if(confirm("Удалить данную запись?")) {
            var id = $(this).attr("data-id"),
                me = $(this);
            me.addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=fq",
                type: "POST",
                data: {
                    "action" : "remove-faq",
                    "id": id
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при удалении записи");
                    }
                    else {
                        $(".faq-box[data-id="+id+"]").remove();
                        if($("#aqs .faq-box").length == 0) {
                            $("#aqs").html(data);
                        }
                        showMessage("Запись была успешно удалена");
                    }
                    me.removeClass("loader").removeClass("glyphicon-refresh");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    me.removeClass("loader").removeClass("glyphicon-refresh");
                }
            });
        }
        e.preventDefault();
    });
    /* ADD */
    $("#faq-add").click(function() {
        var title = $("#faq-question").val(),
            answer = $("#faq-answer").val(),
            btn = $(this);
        if(title != '' && answer != '') {
            $(btn).html("Добавить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=fq",
                type: "POST",
                data: {
                    "action" : "add-faq",
                    "question": title,
                    "answer": answer
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при добавлении записи");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        if($("#aqs .faq-box").length == 0) {
                           $("#aqs").html(data);
                        }
                        else {
                            $(data).prependTo("#aqs");
                        }
                        showMessage("Запись была успешно добавлена");
                    }
                    $(btn).html("Добавить");
                    $("#faq-question").val("");
                    $("#faq-answer").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Добавить");
                    $("#faq-question").val("");
                    $("#faq-answer").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* CHANGE */
    $("body").on("click", ".faq-save", function() {
        var id = $(this).attr("data-id"),
            title = $(".faq-question[data-id="+ id +"]").val(),
            answer = $(".faq-answer[data-id="+ id +"]").val(),
            btn = $(this);
        if(title != '' && answer != '') {
            $(btn).html("Сохранить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=fq",
                type: "POST",
                data: {
                    "action" : "change-faq",
                    "id": id,
                    "question": title,
                    "answer": answer
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".faq-title[data-id="+ id +"]").text(title);
                        showMessage("Запись была успешно сохранена");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Произошла ошибка при сохранении записи");
                    }
                    $(btn).html("Сохранить");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Сохранить");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
});