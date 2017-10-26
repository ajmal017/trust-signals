$(document).ready(function() {
    $("#content").on("click", ".lock-banned-usr", function(e) {
        var message = prompt("Причина бана");
        if(message != "") {
            var id = $(this).attr("data-id"),
            tmp = "<span class='unlock-banned-usr' data-id='" + id + "'><span class='fa fa-unlock'></span> Убрать бан</span> | <a href='#' data-message='" + message + "' class='show-banned-message'>причина</a>";
            
            var loader = '<i class="fa fa-spinner fa-spin"></i>';
            $(".banned-" + id).html(loader);

            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "lock-user",
                    "id" : id,
                    "message" : message
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка");
                    }
                    else {
                        $(".banned-" + id).html(tmp);
                    }
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        else {
            showMessage("Укажите причину бана");
        }
    });
    $("#content").on("click", ".unlock-banned-usr", function(e) {
        var id = $(this).attr("data-id"),
            tmp = "<span class='lock-banned-usr' data-id='" + id + "'><span class='fa fa-lock'></span> Блокировать</span>";
        
        var loader = '<i class="fa fa-spinner fa-spin"></i>';
        $(".banned-" + id).html(loader);

        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "unlock-user",
                "id" : id
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка");
                }
                else {
                    $(".banned-" + id).html(tmp);
                }
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
            }
        });
    });
    $("#content").on("click", ".show-banned-message", function(e) {
        alert($(this).attr("data-message"));
        e.preventDefault();
    });
    /* SEARCH ORDERS */
    $(document).keyup(function() {
        var search = document.getElementById("search-canvas-orders");
        if(search == document.activeElement) {
            var title = $("#search-canvas-orders").val(),
                titleRep = title.replace(" ", "+");
            history.pushState(null, null, titleRep + "_page1");
            $(".page-name").html("Список оплат <span class='loader glyphicon glyphicon-refresh'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "search-orders",
                    "title": title
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка");
                    }
                    else {
                        $("#orders-list").html(data);
                        $("*[data-toggle=tooltip]").tooltip();
                    }
                    $(".page-name").html("Список оплат");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Список оплат");
                }
            });
        }
    });
    /* UPLOAD BASE */
    $("#reload-base").click(function() {
        var btn = $(this);
        $(btn).html("Обновить базу <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "reload-base"
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при обновлении");
                }
                else {
                    showMessage("База была обновлена" + data);
                    $(".downloadbase").slideDown(300);
                }
                $(btn).html("Обновить базу");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Обновить базу");
            }
        });
    });
    /* EDIT */
    $("body").on("click", "#activate-users", function() {
        var btn = $(this);
        $(btn).html("Активировать всех пользователей <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "activate-all"
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Пользователи были активированы");
                }
                else {
                    showMessage("Произошла ошибка при сохранении");
                }
                $(btn).html("Активировать всех пользователей");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Активировать всех пользователей");
            }
        });
    });
    $("body").on("click", ".activate-user", function() {
        var id = $(this).attr("data-id")
            btn = $(this);
        $(btn).html("<span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "activate",
                "id": id
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Пользователь был активирован");
                }
                else {
                    showMessage("Произошла ошибка при сохранении");
                }
                $(btn).remove();
                $(btn).html('<span class="glyphicon glyphicon-ok"></span>');
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html('<span class="glyphicon glyphicon-ok"></span>');
            }
        });
    });
    //HANDLES
    $("#add-btn-timeleft").click(function() {
        var id = $(this).attr("data-id"),
            time = $("#set-val-timeleft").val(),
            btn = $(this);
        $(btn).html("Добавить <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "add-timeleft",
                "id": id,
                "time": time
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при сохранении");
                }
                else {
                    showMessage("Время было успешно установлено");
                }
                $(btn).html("Добавить");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Добавить");
            }
        });
    });
    $("#add-btn-time-vip").click(function() {
        var id = $(this).attr("data-id"),
            time = $("#set-val-time-vip").val(),
            btn = $(this);
        $(btn).html("Добавить <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "add-time-vip",
                "id": id,
                "time": time
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при сохранении");
                }
                else {
                    showMessage("Время было успешно установлено");
                }
                $(btn).html("Добавить");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Добавить");
            }
        });
    });
    $("#set-btn-time-vip").click(function() {
        var id = $(this).attr("data-id"),
            time = $("#set-val-time-vip").val(),
            btn = $(this);
        $(btn).html("Установить <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "change-time-vip",
                "id": id,
                "time": time
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при сохранении");
                }
                else {
                    showMessage("Время было успешно установлено");
                }
                $(btn).html("Установить");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Установить");
            }
        });
    });
    $("#set-btn-timeleft").click(function() {
        var id = $(this).attr("data-id"),
            time = $("#set-val-timeleft").val(),
            btn = $(this);
        $(btn).html("Установить <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users_adm",
            type: "POST",
            data: {
                "action" : "change-timeleft",
                "id": id,
                "time": time
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Произошла ошибка при сохранении");
                }
                else {
                    showMessage("Время было успешно установлено");
                }
                $(btn).html("Установить");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(btn).html("Установить");
            }
        });
    });
    $("#set-btn-password").click(function() {
        var id = $(this).attr("data-id"),
            password = $("#set-val-password").val(),
            btn = $(this);
        if(password != '') {
            $(btn).html("Изменить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "change-pass",
                    "id": id,
                    "password": password
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при сохранении");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Пароль был успешно сохранен");
                    }
                    $(btn).html("Изменить");
                    $("#set-val-password").val("");

                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Изменить");
                    $("#set-val-password").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля правильно");
        }
    });
    $("#set-btn-email").click(function() {
        var id = $(this).attr("data-id"),
            email = $("#set-val-email").val(),
            btn = $(this);
        if(email.search(/^([\w\.\-\_]+)\@([\w\-\_\.]+)\.([\w]{2,6})$/) != -1) {
            $(btn).html("Изменить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "change-email",
                    "id": id,
                    "email": email
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при сохранении");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("E-mail был успешно сохранен");
                    }
                    $(btn).html("Изменить");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Изменить");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля правильно");
        }
    });
    //OPEN
    $("#content").on("click", ".edit-user", function() {
        var id = $(this).attr("data-user"),
            email = $(this).attr("data-email"),
            timeVip = $(this).attr("data-time-vip"),
            timeLeft = $(this).attr("data-timeleft"),
            from = $(this).attr("data-from"),
            soc = $(this).attr("data-soc");
        $("#settings button").attr("data-id", id);
        $("#set-val-email").val(email);
        $("#basic-time").text(timeLeft);
        $("#vip-time").text(timeVip);
        $("#user-soc-address").text(soc);
        $("#user-from-reg").text(from);
    });
    /* REMOVE */
    $("#content").on("click", ".remove-user", function() {
        if(confirm("Удалить данного пользователя?")) {
            var id = $(this).attr("data-id"),
                me = $(this);
            me.find("span").addClass("loader").addClass("glyphicon-refresh");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "remove-user",
                    "id": id
                },
                success: function(data) {
                    if(data == 'success') {
                        $(".user-num-" + id).addClass("supp-danger");
                        me.find("span").removeClass("loader").removeClass("glyphicon-refresh");
                        me.removeClass("label-danger").addClass("label-default").removeClass("remove-order");
                        $(".edit-user[data-user=" + id + "]").remove();
                        $(".user-send-mess-" + id).remove();
                        showMessage("Плдьзователь был успешно удален");
                    }
                    else {
                        showMessage("Произошла ошибка при удалении");
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
    /* SEARCH */
    $(document).keyup(function() {
        var search = document.getElementById("search-canvas");
        if(search == document.activeElement) {
            var title = $("#search-canvas").val(),
                titleRep = title.replace(" ", "+");
            history.pushState(null, null, titleRep + "_page1");
            $(".page-name").html("Список пользователей <span class='loader glyphicon glyphicon-refresh'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=users_adm",
                type: "POST",
                data: {
                    "action" : "search",
                    "title": title
                },
                success: function(data) {
                    if(data == 'error') {
                        showMessage("Произошла ошибка при удалении записи");
                    }
                    else {
                        $("#users-content").html(data);
                        $("*[data-toggle=tooltip]").tooltip();
                    }
                    $(".page-name").html("Список пользователей");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Список пользователей");
                }
            });
        }
    });
});