$(document).ready(function() {
    var sort = 1,
        added = 0,
        added_a = 0;
    /* EDIT */
    $("#edit-str").click(function() {
        var title = $("#edit-title").val(),
            text = CKEDITOR.instances['edit-desc'].getData(),
            btn = $(this),
            bt = btn.text(),
            id = btn.attr("data-id");
        btn.html(bt + " <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                "action": "strategy-edit",
                "id": id,
                "text": text,
                "title": title
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Стратегия была успешно сохранена");
                    btn.text(bt);
                }
                else if(data == 'empty') {
                    showMessage("Заполните все поля");
                    btn.text(bt);
                }
                else {
                    showMessage("Произошла ошибка при сохранении");
                    btn.text(bt);
                }
                btn.html(bt);
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                btn.text(bt);
            }
        });
    });
    /* FULL IMG */
    $("body").on("click", ".open-img", function() {
        var img = $(this).attr("data-img"),
            title = $(this).attr("data-title");
        $("#img-modal-full").attr("src", img);
        $("#article-modal").text(title);
    });
    /* REMOVE STRATEGIES */
    $("#content").on("click", ".remove-str", function(e) {
        if(confirm("Вы хотите удалить данныую стратегию?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'remove-str',
                    "id" : id
                },
                success:function(data){
                    added = false;
                    if(data == 'error') {
                        showMessage("Ошибка при попытке удалить стратегию");
                    }
                    else if(data == 'success') {
                        showMessage("Стратегия была успешно удалена");
                        $("#str-id-" + id).css({
                            "background" : "#FA5555",
                            "color" : "#fff"
                        });
                        $("#str-id-" + id + " .moder-panel").remove();
                        $("#str-id-" + id + " .btn.btn-info").remove();
                    }
                    else {
                        showMessage("Ошибка при попытке удалить стратегию");
                    }
                },
                fail:function(){
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        e.preventDefault();
    });
    /* OK VIDEO */
    $("#content").on("click", ".ok-video", function(e) {
        if(confirm("Вы хотите утвердить данный ролик?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'ok-video',
                    "id" : id
                },
                success:function(data){
                    added = false;
                    if(data == 'error') {
                        showMessage("Ошибка при попытке утвердить видео");
                    }
                    else if(data == 'success') {
                        showMessage("Ролик был успешно утвержден");
                        $("#usr-video-" + id + " .panel-heading").attr("style", "background: #53BE7D !important;");
                        $("#usr-video-" + id + " .moder-nav .ok-video").remove();
                    }
                    else {
                        showMessage("Ошибка при попытке утвердить видео");
                    }
                },
                fail:function(){
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        e.preventDefault();
    });
    /* REMOVE VIDEO */
    $("#content").on("click", ".remove-video", function(e) {
        if(confirm("Вы хотите удалить данный ролик?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'remove-video',
                    "id" : id
                },
                success:function(data){
                    added = false;
                    if(data == 'error') {
                        showMessage("Ошибка при попытке удалить видео");
                    }
                    else if(data == 'success') {
                        showMessage("Ролик был успешно удален");
                        $("#usr-video-" + id + " .panel-heading").attr("style", "background: #FA5555 !important;");
                        $("#usr-video-" + id + " .moder-nav").remove();
                    }
                    else {
                        showMessage("Ошибка при попытке удалить видео");
                    }
                },
                fail:function(){
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        e.preventDefault();
    });
    /* ADD VIDEO ADMIN */
    $("#a-add-video").click(function() {
        if(!added_a) {
            $(".a-loader-changer").removeClass("glyphicon-plus-sign").addClass("glyphicon-refresh loader");
            added_a = true;
            var name = $("#a-video-name").val(),
                url = $("#a-video-url").val();
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'a-add-video',
                    "name" : name,
                    "url"  : url
                },
                success:function(data){
                    added_a = false;
                    if(data == 'url') {
                        showMessage("Вы указали неверный адрес на видео");
                    }
                    else if(data == 'empty') {
                        showMessage("Вы заполнили не все необходимые поля");
                    }
                    else if(data == 'success') {
                        showMessage("Ваш ролик был добавлен");
                        $("#a-video-name").val("");
                        $("#a-video-url").val("");
                    }
                    else {
                        showMessage("Ошибка при попытке добавить видео");
                    }
                    $(".a-loader-changer").addClass("glyphicon-plus-sign").removeClass("glyphicon-refresh").removeClass("loader");
                },
                fail:function(){
                    $(".a-loader-changer").addClass("glyphicon-plus-sign").removeClass("glyphicon-refresh").removeClass("loader");
                    showMessage("Проверьте соединение с интернетом");
                    added_a = false;
                }
            });
        }
        else {
            showMessage("Ошибка загрузки токена");
        }
    });
    /* ADD VIDEO */
    $("#add-video").click(function() {
        if(!added) {
            $(".loader-changer").removeClass("glyphicon-plus-sign").addClass("glyphicon-refresh loader");
            added = true;
            var name = $("#video-name").val(),
                url = $("#video-url").val();
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'add-video',
                    "name" : name,
                    "url"  : url
                },
                success:function(data){
                    added = false;
                    if(data == 'url') {
                        showMessage("Вы указали неверный адрес на видео");
                    }
                    else if(data == 'empty') {
                        showMessage("Вы заполнили не все необходимые поля");
                    }
                    else if(data == 'success') {
                        showMessage("Ваш ролик будет рассмотрен модераторами сервиса");
                        $("#video-name").val("");
                        $("#video-url").val("");
                    }
                    else {
                        showMessage("Ошибка при попытке добавить видео");
                    }
                    $(".loader-changer").addClass("glyphicon-plus-sign").removeClass("glyphicon-refresh").removeClass("loader");
                },
                fail:function(){
                    $(".loader-changer").addClass("glyphicon-plus-sign").removeClass("glyphicon-refresh").removeClass("loader");
                    showMessage("Проверьте соединение с интернетом");
                    added = false;
                }
            });
        }
        else {
            showMessage("Ошибка загрузки токена");
        }
    });
    /* VOTES ( LIKES ) */
    $("body").on("click", ".video-set-vote", function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'set-vote',
                "id" : id
            },
            success:function(data){
                if(data == 'was') {
                    showMessage("Вы уже поставили свой голос в этом видео");
                }
                else if(data == 'success') {
                    var box = $("#usr-video-" + id + " .video-votes-amount"),
                        am = $(box).text(),
                        am = Number(am) + 1;
                    $(box).text(am);
                }
                else {
                    showMessage("Ошибка при попытке поставить \"Лайк\"");
                    $(".strategies-full-box .load-more-information .load-text").text("Загрузить ещё");
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
            }
        });
    });
    /* LOAD */
    var num3 = 10;
    $(".strategies-full-box-vip .load-more-information").click(function() {
        $(".strategies-full-box-vip .load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-strategies',
                n : num3,
                type : 'vip'
            },
            success:function(data){
                if(data == 'empty') {
                    $(".strategies-full-box-vip .load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".strategies-full-box-vip .load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".strategies-full-box-vip .load-more-information .load-text").text("Загрузить ещё");
                    $("#strategies-list-vip").append(data);
                    num3 += 10;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    /* LOAD */
    var num = 10;
    $(".strategies-full-box .load-more-information").click(function() {
        $(".strategies-full-box .load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-strategies',
                n : num
            },
            success:function(data){
                if(data == 'empty') {
                    $(".strategies-full-box .load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".strategies-full-box .load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".strategies-full-box .load-more-information .load-text").text("Загрузить ещё");
                    $("#strategies-list").append(data);
                    num += 10;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    var num2 = 4;
    $(".video-full-box .load-more-information").click(function() {
        $(".video-full-box .load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-videos',
                n : num2,
                'sort' : sort
            },
            success:function(data){
                if(data == 'empty') {
                    $(".video-full-box .load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".video-full-box .load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".video-full-box .load-more-information .load-text").text("Загрузить ещё");
                    $("#videos-list").append(data);
                    num2 += 4;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".video-full-box .load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    /* SORT */
    $(".sort-method").click(function(e) {
        e.preventDefault();
        var type = $(this).attr("data-sort");
        sort = type;
        $("#sort-title").text($(this).text());
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-videos',
                n : 0,
                'sort' : sort
            },
            success:function(data){
                if(data == 'empty') {
                    showMessage("Ошибка перевода данных");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                }
                else {
                    $("#videos-list").html(data);
                    num2 = 4;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
            }
        });
    });
});