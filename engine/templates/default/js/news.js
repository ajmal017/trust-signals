$(document).ready(function() {
    /* MASK */
    $("#news-time").mask("9999-99-99 99:99");
    /* ADD */
    $("#news-add").click(function() {
        var time = $("#news-time").val(),
            btn = $(this);
        if(time.search(/^\d{4}\-\d{2}\-\d{2}\ \d{2}\:\d{2}$/) != -1) {
            $(btn).html("Добавить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=news",
                type: "POST",
                data: {
                    "action" : "add-news",
                    "time": time
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при добавлении записи");
                    }
                    else if(data == 'format') {
                        showMessage("Пожалуйста, заполните поле с датой правильно");
                    }
                    else {
                        if($("#news .eco-news").length == 0) {
                            $("#news").html(data);
                        }
                        else {
                            $(data).prependTo("#news");
                        }
                        showMessage("Запись была успешно добавлена");
                    }
                    $(btn).html("Добавить");
                    $("#news-time").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Добавить");
                    $("#news-time").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните поле с датой правильно");
        }
    });
    /* REMOVE */
    $("#content").on("click", ".remove-click", function() {
        if(confirm("Удалить данную запись?")) {
            var me = $(this),
                id = me.attr("data-id"),
                box = $(".news-" + id);
            me.addClass("loader");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=news",
                type: "POST",
                data: {
                    "action" : "remove-news",
                    "id": id
                },
                success: function(data) {
                    if(data == 'success') {
                        box.css({
                            "background" : "#333",
                            "opacity" : ".6",
                            "color":"#fff !important"
                        });
                        box.find("span").css("color", "#fff");
                        showMessage("Запись была успешно удалена");
                    }
                    else {
                        showMessage("Произошла ошибка при удалении записи");
                    }
                    me.removeClass("loader");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    me.removeClass("loader");
                }
            });
        }
    });
});