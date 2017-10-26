$(document).ready(function() {
    /* LOAD */
    var num = 10;
    $(".load-more-information").click(function() {
        $(".load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=mails",
            type: "POST",
            data: {
                action: 'load-mails',
                n : num
            },
            success:function(data){
                if(data == 'empty') {
                    $(".load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".load-more-information .load-text").text("Загрузить ещё");
                    $("#mails").append(data);
                    num += 10;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    var remId;
    /* REMOVE */
    $("#mails").on("click", ".remove-message", function(e) {
        remId = $(this).attr("data-id");
        e.preventDefault();
    });
    $("#remove-once").click(function(e) {
        var id = remId;
        $(".page-name").html("Мои сообщения <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=mails",
            type: "POST",
            data: {
                action: 'remove-messages',
                "id" : id
            },
            success:function(data){
                if(data != 'error') {
                    $("#mail-box-" + id).remove();
                    if($(".mail").length == 0) {
                        $("#mails").html(data);
                        $(".load-more-information").remove();
                    }
                    showMessage("Сообщение было удалено");
                    $(".page-name").html("Мои сообщения");
                }
                else {
                    showMessage("Ошибка при удалении сообщения");
                    $(".page-name").html("Мои сообщения");
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Мои сообщения");
            }
        });
        e.preventDefault();
    });
    $("#remove-messages").click(function(e) {
        var id = remId;
        $(".page-name").html("Мои сообщения <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=mails",
            type: "POST",
            data: {
                action: 'remove-messages',
                "id" : id,
                "remove-all": 1
            },
            success:function(data){
                if(data != 'error') {
                    $("#mails").html(data);
                    $(".load-more-information").remove();
                    showMessage("Сообщения были удалены");
                    $(".page-name").html("Мои сообщения");
                }
                else {
                    showMessage("Ошибка при удалении сообщений");
                    $(".page-name").html("Мои сообщения");
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Мои сообщения");
            }
        });
        e.preventDefault();
    });
    /* LOAD MESSAGE */
    $("#mails").on("click", ".open-message", function(e) {
        var id = $(this).attr("data-id");
        $(".page-name").html("Мои сообщения <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=mails",
            type: "POST",
            data: {
                action: 'load-message',
                "id" : id
            },
            success:function(data){
                if(data == 'empty' || data == 'access' || data == '') {
                    $(".page-name").text("Мои сообщения");
                    showMessage("Данное сообщение не существует");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".page-name").text("Мои сообщения");
                }
                else {
                    $(".page-name").text("Мои сообщения");
                    $("#mails").animate({"opacity":0}, 600, function() {
                        $("#mails").html(data);
                        $("#mails").animate({"opacity":1}, 600);
                    });
                    $(".load-more-information").slideUp(300);
                    $(".load-more-information .load-text").html("Загрузить ещё");

                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".page-name").html("Мои сообщения");
            }
        });
        e.preventDefault();
    });
    /* BACK */
    $("#mails").on("click", ".back-to-message", function(e) {
        $(".page-name").html("Мои сообщения <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=mails",
            type: "POST",
            data: {
                action: 'load-mails',
                n : 0
            },
            success:function(data){
                num = 10;
                if(data == 'empty') {
                    showMessage("Список сообщений пустой");
                    $(".page-name").text("Мои сообщения");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".page-name").text("Мои сообщения");
                }
                else {
                    $("#mails").animate({"opacity":0}, 600, function() {
                        $("#mails").html(data);
                        $("#mails").animate({"opacity":1}, 600, function() {
                            $(".load-more-information").slideDown(300);
                            $(".page-name").text("Мои сообщения");
                        });
                    });
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
            }
        });
    });
});