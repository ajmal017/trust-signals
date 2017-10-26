$(document).ready(function() {
    $(".clear-history").click(function(e) {
        if(confirm("Очистить историю?")) {
            var me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "remove-supp-full"
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
    var isWork = true;
    $(".send-message-button").click(function() {
        if(isWork) {
            $(this).html("<span class='glyphicon glyphicon-refresh loader'></span> Ответить");
            isWork = false;
            var id = $(this).attr("data-id"),
                email = $(this).attr("data-email"),
                text = $(".send-message-input").val(),
                btn = $(this);
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "send-message",
                    "id": id,
                    "email": email,
                    "text" : text
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при отправке сообщения");
                    }
                    else if(data == 'empty'){
                        showMessage("Заполните все поля");
                    }
                    else {
                        showMessage("Сообщение было успешно отправлено");
                        $(".chat-content").prepend(data);
                        $(".send-message-input").val("");
                    }
                    $(btn).html("Ответить");
                    isWork = true;
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Ответить");
                    isWork = true;
                }
            });
        }
        else {
            showMessage("Пожалуйсте подождите...");
            $(btn).html("Ответить");
        }
    });
    /* STYLES */
    $(".chat-contact").niceScroll({
        cursorcolor:"#999",
        cursoropacitymin:0,
        cursoropacitymax:0.3,
        cursorwidth:5,
        cursorborder:"0px",
        cursorborderradius:"0px",
        cursorminheight:50,
        zindex:1,
        mousescrollstep:20
    });

    $(".chat-content").niceScroll({
        cursorcolor:"#999",
        cursoropacitymin:0,
        cursoropacitymax:0.3,
        cursorwidth:5,
        cursorborder:"0px",
        cursorborderradius:"0px",
        cursorminheight:50,
        zindex:1,
        mousescrollstep:20
    });
    /* ADD LINK */
    $("#link-add").click(function() {
        var link = $("#link-address").val(),
            desc = $("#link-description").val(),
            me = $(".title-add-link");
        me.find("span").addClass("loader").addClass("glyphicon-refresh");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=supp",
            type: "POST",
            data: {
                "action" : "add-link",
                "link": link,
                "description": desc
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при добавлении записи");
                }
                else if(data == 'empty'){
                    showMessage("Заполните все поля");
                }
                else {
                    me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                    $("#links-list").after(data);
                    showMessage("Запись была успешно добавлена");
                }
                me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
            }
        });
    });
    /* REMOVE LINKS */
    $("#content").on("click", ".remove-link", function() {
        if(confirm("Удалить данную запись?")) {
            var id = $(this).attr("data-id"),
                me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "remove-link",
                    "id": id
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".link-" + id).addClass("supp-success");
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
    });
    /* POSTS */
    $("#posts-btn").click(function() {
        var btn = $(this),
            text = $("#posts-text").val();
        if(text != '') {
            $(btn).html("Разослать <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "posts-message",
                    "text": text
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при отправке сообщения");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Сообщения были успешно отправлены");
                    }
                    $(btn).html("Разослать");
                    $("#posts-text").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Разослать");
                    $("#posts-text").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* REMOVE SUPP */
    $(".remove-supp").click(function(e) {
        if(confirm("Удалить данную запись?")) {
            var id = $(this).attr("data-id"),
                email = $(this).attr("data-email"),
                me = $(this),
                ids = $(this).attr("data-id-supp");
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "remove-supp",
                    "id": id,
                    "email" : email
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".supp-" + ids).addClass("supp-success");
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
    /* SEND MESSAGE */
    var tmpList = $("#tmp-list").text().split("|");
    for(var i = 0; i < tmpList.length; i++) {
        $("#templates-posts").append('<div class="tmp-message">' + tmpList[i] + '</div>');
    }
    $(".tmp-message").css({
        "cursor" : "pointer",
        "margin" : "2px",
        "padding" : "5px",
        "display" : "block"
    });
    $("#content").on("click", ".tmp-message", function() {
        var text = $(this).text();
        $("#send-text-post").val(text);
    });
    $("body").on("click", ".send-post", function() {
        var email = $(this).attr("data-email");
        $("#send-btn-post").attr('data-email', email);
        $("#send-text-post").val("");
    });
    $("body").on("click", ".send-message", function() {
        var id = $(this).attr("data-user");
        $("#send-btn").attr('data-id', id);
        $("#send-text").val("");
    });
    $("body").on("click", ".send-message-email", function() {
        var email = $(this).attr("data-email");
        $("#send-btn-email").attr('data-email', email);
        $("#send-text-email").val("");
    });
    $("#send-btn-post").click(function() {
        var btn = $(this),
            email = $(btn).attr("data-email"),
            text = $("#send-text-post").val();
        if(text != '') {
            $(btn).html("Отправить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "send-message-post",
                    "email": email,
                    "text": text
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при отправке сообщения");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        console.log(data);
                        showMessage("Сообщение было успешно отправлено");
                    }
                    $(btn).html("Отправить");
                    $("#send-text-post").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Отправить");
                    $("#send-text-post").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    $("#send-btn-email").click(function() {
        var btn = $(this),
            email = $(btn).attr("data-email"),
            text = $("#send-text-email").val();
        if(text != '') {
            $(btn).html("Отправить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "send-message-email",
                    "email": email,
                    "text": text
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при отправке сообщения");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Сообщение было успешно отправлено");
                    }
                    $(btn).html("Отправить");
                    $("#send-text-email").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Отправить");
                    $("#send-text-email").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    $("#send-btn").click(function() {
        var btn = $(this),
            id = $(btn).attr("data-id"),
            text = $("#send-text").val();
        if(text != '') {
            $(btn).html("Отправить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=supp",
                type: "POST",
                data: {
                    "action" : "send-message",
                    "id": id,
                    "text": text
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при отправке сообщения");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Сообщение было успешно отправлено");
                    }
                    $(btn).html("Отправить");
                    $("#send-text").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Отправить");
                    $("#send-text").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
});