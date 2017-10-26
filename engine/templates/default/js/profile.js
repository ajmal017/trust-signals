$(document).ready(function() {
    var button = $("#load-img-button2");
    new AjaxUpload(button, {
        name: "img",
        action: "../index.php?page=ajax&ajax-handle=profile",
        hoverClass: "",
        onSubmit: function(file, ext) {
            if(ext == "jpg" || ext == "png" || ext == "jpeg") {
                button.html("<span class='glyphicon glyphicon-refresh loader'></span> Загрузка");
            }
            else {
                showMessage("Изображение должно быть форматов jpeg или png");
            }
        },
        onComplete: function(file, response) {
            if(response == "types") {
                showMessage("Изображение должно быть форматов jpeg или png");
            }
            else if(response == "size") {
                showMessage("Размер изображения должен быть не более 200Кб");
            }
            else {
                showMessage("Изменения прошли успешно");
                $("#drop-author-panel img, .user-box img, .user-picture img").attr("src", response);
            }
            button.html('<span class="glyphicon glyphicon-picture"></span> Загрузить картинку');
        }
    });
    /* INCLUDES QUOTES */
    $("input[name='quotes-list']").change(function() {
        $("#quotes-description").html("Настройка VIP кабинета <span class='glyphicon glyphicon-refresh loader'></span>");
        if($(this).prop("checked")) {
            changeQuotes("add-match-to-list", $(this).val());
        }
        else {
            changeQuotes("remove-match-to-list", $(this).val());
        }
    });
    function changeQuotes(act, val) {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=profile",
            data: {
                action: act,
                match: val
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Изменения прошли успешно");
                }
                else {
                    showMessage("Ошибка при попытке изменения");
                }
                $("#quotes-description").html("Настройка VIP кабинета");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#quotes-description").html("Настройка VIP кабинета");
            }
        });
    }
    /* CHANGE PASSWORD */
    $(".btn-change-pass").click(function() {
        $("#pass-description").html("Изменить пароль <span class='glyphicon glyphicon-refresh loader'></span>");
        var pass = $("#change-pass-value").val(),
            repeat = $("#change-repeat-pass-value").val();
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=profile",
            data: {
                action: "change-pass",
                password: pass,
                repeatPass: repeat
            },
            success: function(data) {
                $("#change-pass-value").val("");
                $("#change-repeat-pass-value").val("");
                $("#pass-description").html("Изменить пароль");
                if(data == 'success') {
                    showMessage("Изменения прошли успешно");
                }
                else if(data == 'empty') {
                    showMessage("Пароль пустой");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
                else if(data == 'equalize') {
                    showMessage("Пароли не совпадают");
                }
                else if(data == 'easy') {
                    showMessage("Пароль должен быть больше 7-и символов");
                }
            },
            fail: function(data) {
                showMessage("Проверьте соединение с интернетом");
                $("#pass-description").html("Изменить пароль");
            }
        });
    });
    /* CHANGE SOCIAL ADDRESS */
    $(".btn-change-soc").click(function() {
        $("#soc-description").html("Изменить адрес соц.страницы <span class='glyphicon glyphicon-refresh loader'></span>");
        var name = $("#change-soc-value").val();
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=profile",
            data: {
                action: "change-soc",
                name: name
            },
            success: function(data) {
                $("#change-soc-value").val("");
                $("#soc-description").html("Изменить адрес соц.страницы");
                if(data == 'success') {
                    $("#change-soc-value").attr("placeholder", name);
                    showMessage("Изменения прошли успешно");
                }
                else if(data == 'empty') {
                    showMessage("Заполнете поле с соц. адресом");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
                else if(data == 'format') {
                    showMessage("Адрес введен неверно");
                }
            },
            fail: function(data) {
                showMessage("Проверьте соединение с интернетом");
                $("#soc-description").html("Изменить адрес соц.страницы");
            }
        });
    });
    /* CHANGE NAME */
    $(".btn-change-name").click(function() {
        $("#name-description").html("Изменить имя <span class='glyphicon glyphicon-refresh loader'></span>");
        var name = $("#change-name-value").val(),
            email = $("#change-email-value").val();
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=profile",
            data: {
                action: "change-name",
                name: name,
                email: email
            },
            success: function(data) {
                $("#name-description").html("Изменить имя");
                if(data == 'success') {
                    $(".user-name").text(name);
                    showMessage("Изменения прошли успешно");
                }
                else if(data == 'empty') {
                    showMessage("Заполнете поле с Вашим именем");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
                else if(data == 'email') {
                    showMessage("E-mail адрес указан неверно");
                }
            },
            fail: function(data) {
                showMessage("Проверьте соединение с интернетом");
                $("#name-description").html("Изменить имя");
            }
        });
    });
});