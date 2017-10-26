$(document).ready(function() {
    $('*[data-toggle=tooltip]').tooltip();
    $('*').popover();
    $("li a").each(function(e) {
        if($(this).attr("href") == location.href) {
            $(this).parent("li").addClass("header-active");
        }
    });
    /* SEND MESSAGE */
    $("#supp-btn").click(function() {
        $("#supp-btn").html("Отправить <span class='glyphicon glyphicon-refresh loader'></span>");
        var subject = $("#supp-subject").val(),
            text = $("#supp-text").val(),
            name = $("#supp-name").val(),
            email = $("#supp-email").val();
        $.ajax({
            method: "POST",
            url: "/index.php?page=ajax&ajax-handle=home",
            data: {
                action: "send",
                "subject": subject,
                "text": text,
                "name": name,
                "email": email
            },
            success: function(data) {
                $("#supp-text").val("");
                $("#supp-name").val("");
                $("#supp-email").val("");
                $("#supp-subject").val("");
                $("#supp-btn").html("Отправить");
                if(data == 'success') {
                    showMessage("Сообщение было отправлено");
                }
                else if(data == 'format') {
                    showMessage("Поле E-mail указано неверно");
                }
                else if(data == 'empty') {
                    showMessage("Заполните все необходимые поля");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#supp-btn").html("Отправить");
                $("#supp-text").val("");
                $("#supp-name").val("");
                $("#supp-email").val("");
                $("#supp-subject").val("");
            }
        });
    });
    $("#email-change-btn").click(function() {
        var email = $("#email-change").val(),
            id = $(this).attr("data-id"),
            me = $(this);
        me.html("Сохранить E-mail и отправить данные на почту <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            "method": "POST",
            "url": "/index.php?page=ajax&ajax-handle=home",
            "data": {
                "email": email,
                "id": id,
                "action": "change-email"
            },
            success: function(data) {
                if(data == 'data') {
                    showMessage("Произошла ошибка при авторизации");
                }
                else if(data == 'format') {
                    showMessage("Поле E-mail указано неверно");
                }
                else if(data == 'exists') {
                    showMessage("Пользователь с таким E-mail адресом уже существует");
                }
                else {
                    showMessage("Авторизация прошла успешно");
                    location.href = "/cabinet/";
                }
                $("#email-change").val("");
                me.html("Сохранить E-mail и отправить данные на почту");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#email-change").val("");
                me.html("Сохранить E-mail и отправить данные на почту");

            }
        });
    });
    function showMessage(message) {
        if($(".alert-message").length > 0) {
            $(".alert-message").text(message);
        }
        else {
            $("<div class='alert-message'>"+ message +"</div>").appendTo("body");
            $(".alert-message").slideDown(300);
            setTimeout(function() {
                $(".alert-message").animate({"height":"0px"}, 300, function() {
                    $(".alert-message").remove();
                });
            }, 3000);
        }
    }
});