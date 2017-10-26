$(document).ready(function() {
    /* INIT STYLES */
    $("*[data-toggle=tooltip]").tooltip();
    $("select").styler();
    /* SYSTEMS */
    $(".change-system-canvas").change(function() {
        var val = $(this).prop("checked");
            val = val == false ? 0 : 1,
            id = $(this).attr("data-id");
        var word = val == 0 ? "отключена" : "включена";
        $(".page-name").html("Платежние системы <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                action: "systems",
                "val": val,
                "id" : id
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Платежная система " + word);
                }
                else {
                    showMessage("Произошла ошибка при настройке опции");
                }
                $(".page-name").html("Платежние системы");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Платежние системы");
            }
        });
    });
    /* CLEANER */
    $("#base-cleaner").click(function() {
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "cleaner"
            },
            success: function(data) {
                $("#base-cleaner span").html(data);
                showMessage("База была оптимизирована");
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* ELLY */
    $(".elly-save").click(function() {
        var elly = $("#elly").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "elly",
                "elly": elly
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Данные сохранены");
                }
                else {
                    showMessage("Ошибка при сохранении");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* API */
    $(".api-save").click(function() {
        var key = $("#key-api").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "api",
                "key": key
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Ключ был успешно изменен");
                }
                else {
                    showMessage("Произошла ошибка при настройке ключа");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* DEMO TIME */
    $(".web-time-save").click(function() {
        var course = $("#web-time").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "change-web-demo",
                "demo-val": course
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Время было успешно сохранено");
                }
                else {
                    showMessage("Произошла ошибка при настройке времени");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    $(".time-save").click(function() {
        var course = $("#amount-time").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "change-demo",
                "demo-val": course
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Время было успешно сохранено");
                }
                else {
                    showMessage("Произошла ошибка при настройке времени");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* REMOVE PACKAGE */
    $(".package-remove").click(function() {
        var id = $("#packages-list").val();
        if(id != '' && id != 'Выберете...') {
            $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=settings",
                type: "POST",
                data: {
                    "action" : "remove-package",
                    "id" : id
                },
                success: function(data) {
                    if(data == 'success') {
                        showMessage("Пакет был успешно удален");
                        getIncludes();
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Произошла ошибка при добавлении пакета");
                    }
                    $(".page-name").html("Настройки");
                    $("#packages-list").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Настройки");
                    $("#packages-list").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* ADD PACKAGE */
    $(".package-add").click(function() {
        var price = $("#package-price").val(),
            type = $("#package-type").val(),
            time = $("#package-time").val();
        if(price != '' && type != '' && time != '') {
            $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=settings",
                type: "POST",
                data: {
                    "action" : "add-package",
                    "price" : price,
                    "type" : type,
                    "time" : time
                },
                success: function(data) {
                    if(data == 'success') {
                        showMessage("Пакет был успешно добавлен");
                        getIncludes();
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Произошла ошибка при добавлении пакета");
                    }
                    $(".page-name").html("Настройки");
                    $("#package-price").val("");
                    $("#package-type").val("");
                    $("#package-time").val("");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Настройки");
                    $("#package-price").val("");
                    $("#package-type").val("");
                    $("#package-time").val("");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* KEY */
    $(".key-save").click(function() {
        var key = $("#key-name").val(),
            time = Number($("#key-time").val());
        if(key != '' && time > 0) {
            $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=settings",
                type: "POST",
                data: {
                    action: "install-key",
                    "key" : key,
                    "time" : time
                },
                success: function(data) {
                    if(data == 'success') {
                        showMessage("Данные сохранены успешно");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Произошла ошибка при изменении ключа");
                    }
                    $(".page-name").html("Настройки");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Настройки");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    });
    /* WORLDS */
    $(".worlds-save").click(function() {
        var worlds = $("#world-list-val").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "change-worlds",
                "worlds-val": worlds
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Список выражений был сохранен");
                }
                else {
                    showMessage("Произошла ошибка при сохранении");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* COURSE */
    $(".course-save").click(function() {
        var course = $("#course-val").val();
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                "action": "change-course",
                "course-val": course
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Курс был успешно изменен");
                }
                else {
                    showMessage("Произошла ошибка при настройке курса");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* DEMO */
    $("#web-demo").change(function() {
        var val = $(this).prop("checked");
        val = val == false ? 0 : 1;
        var word = val == 0 ? "выключен" : "включен";
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                action: "web-demo",
                "val": val
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Модуль 'Демо' для WebElly " + word);
                }
                else {
                    showMessage("Произошла ошибка при настройке опции");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    $("#demo").change(function() {
        var val = $(this).prop("checked");
        val = val == false ? 0 : 1;
        var word = val == 0 ? "выключен" : "включен";
        $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                action: "demo",
                "val": val
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Модуль 'Демо' " + word);
                }
                else {
                    showMessage("Произошла ошибка при настройке опции");
                }
                $(".page-name").html("Настройки");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Настройки");
            }
        });
    });
    /* FIND BOX */
    $("body").click(function() {
        $("#find-user-box").slideUp(300);
    });

    $("#find-user-box").on("click", ".find-user-element", function() {
        $("#find-user-box").slideUp(300);
        $("#rules-moder-name").val($(this).attr("data-name"));
        $("#rules-moder-name").attr("data-id", $(this).attr("data-id"));
    });
    /* FUNCTIONAL */
    $(document).keyup(function() {
        var findUserEl = document.getElementById("rules-moder-name");
        if(document.activeElement == findUserEl)
            findUser();
    });
    $(".add-moder").click(installRules);
    $(".remove-moder").click(uninstallRules);
    /* FIND FUNCTION */
    function findUser() {
        $("#find-user-box").slideDown(300);
        var getName = $("#rules-moder-name").val();
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                action: "find-user",
                name: getName
            },
            success: function(data) {
                $("#find-user-box").html(data);
            }
        });
    }
    /* RULES */
    function installRules() {
        var idVk = $("#rules-moder-name").attr("data-id");
        if(typeof idVk != 'undefined' && idVk != '') {
            $(".page-name").html("Настройки <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=settings",
                type: "POST",
                data: {
                    action: "install-rules",
                    id: idVk
                },
                success: function(data) {
                    if(data != 'rules was install') {
                        showMessage("Права установлены");
                        $("#rules-moder-name").removeAttr("data-vk");
                        $("#rules-moder-name").val("");
                    }
                    else {
                        showMessage("Права уже были установлены");
                    }
                    $(".page-name").html("Настройки");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(".page-name").html("Настройки");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
    }

    function uninstallRules() {
        var idVk = $("#rules-moder-name").attr("data-id");
        if(typeof idVk != 'undefined' && idVk != '') {
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=settings",
                type: "POST",
                data: {
                    action: "uninstall-rules",
                    id: idVk
                },
                success: function(data) {
                    if(data != 'rules was uninstall') {
                        showMessage("Права отозваны");
                        $("#rules-moder-name").removeAttr("data-id");
                        $("#rules-moder-name").val("");
                    }
                    else {
                        showMessage("Данный пользователь итак не имеет привилегий");
                    }
                }
            });
        }
        else {
           showMessage("Пожалуйста, заполните все обязательные поля");
        }
    }
    function getIncludes() {
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=settings",
            type: "POST",
            data: {
                action: "get-includes"
            },
            success: function(data) {
                $("#packages-list").remove();
                $("#packages-list-wrapper").html("<select id='packages-list'><option></option>"+data+"</select>");
                $('select').styler();
            }
        });
    }
});
