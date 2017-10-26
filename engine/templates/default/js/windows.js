$(document).ready(function() {
    /* REMOVE */
    $("body").on("click", ".window-remove", function(e) {
        if(confirm("Удалить данную запись?")) {
            var id = $(this).attr("data-id"),
                me = $(this);
            me.addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=windows",
                type: "POST",
                data: {
                    "action" : "remove-window",
                    "id": id
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при удалении записи");
                    }
                    else {
                        $(".window-box[data-id="+id+"]").remove();
                        if($("#aqs .window-box").length == 0) {
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
    $("#window-add").click(function() {
        var title = $("#window-title").val(),
            text = $('#window-text').val(),
            lang = $("#window-lang").val(),
            time = Number($("#window-time").val()),
            btn = $(this);
        if(title != '' && text != '' && lang != '' && time > 0) {
            $(btn).html("Добавить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=windows",
                type: "POST",
                data: {
                    "action" : "add-window",
                    "text": text,
                    "title": title,
                    "lang": lang,
                    "time": time
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при добавлении записи");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        if($("#aqs .window-box").length == 0) {
                            $("#aqs").html(data);
                        }
                        else {
                            $(data).prependTo("#aqs");
                        }
                        showMessage("Запись была успешно добавлена");
                    }
                    $(btn).html("Добавить");
                    $("#window-title").val("");
                    $("#window-tetx").val("");
                    $("#window-lang").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Добавить");
                    $("#window-title").val("");
                    $("#window-tetx").val("");
                    $("#window-lang").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* CHANGE */
    $("body").on("click", ".window-add-save", function() {
        var id = $(this).attr("data-id"),
            title = $(".window-title-save[data-id="+ id +"]").val(),
            lang = $(".window-lang-save[data-id="+ id +"]").val(),
            text = $(".window-text-save[data-id="+id+"]").val(),
            time = Number($("select.window-time-save[data-id="+id+"]").val()),
            btn = $(this);
        if(title != '' && lang != '' && text != ''&& time > 0) {
            $(btn).html("Сохранить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=windows",
                type: "POST",
                data: {
                    "action" : "change-window",
                    "id": id,
                    "text": text,
                    "lang": lang,
                    "time": time,
                    "title": title
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".window-title[data-id="+ id +"]").text(title);
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