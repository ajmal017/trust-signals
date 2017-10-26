$(document).ready(function() {
    $(".open-sub-menu").click(function(e) {
        if($(this).next(".sub-menu").css("display") == "none") {
            $(".sub-menu").slideUp(300);
            $(this).next(".sub-menu").slideDown(300);
        }
        e.preventDefault();
    });
    $("#old-version").click(function() {
        setCookie("old", "1", {"expires":3600*24*30*12});
    });
    /* IMG */
    var button = $("#load-img-button");
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
    /* INITS */
    $(".content").css({"minHeight" : $(".sidebar").height() + 20 + "px"});
    $('*[data-toggle="tooltip"]').tooltip({
        "container" : "body"
    });
    $('input[type=checkbox]').each(function() {
        $(this).prettyCheckable({});
    });
    dropWindow();
    /* UPDATES */
    setInterval(lastTime, 8000);
    setInterval(watchAccess, 2000);
    $(window).resize(function() {
        dropWindow();
    });
    function dropWindow() {
       var widthWindow = $(window).width(),
           pictureWidthProfile = $(".user-data-profile .user-picture img").width(),
           pictureWidth = $(".user-box img").width(),
           marginLeft = widthWindow / 2 - pictureWidth / 2;
       if(widthWindow < 768) {
            $("li[role=presentation]").addClass("full-width");
       }
       else {
           $("li[role=presentation]").removeClass("full-width");
       }
       if(widthWindow < 976) {
           $(".drop-panel").width("100%");
           $(".panel-box .session-clean .badge").css({ right : 20 });
           $(".user-box img").css({"marginLeft" : marginLeft + "px"});
       }
       else {
           $(".drop-panel").width("189px");
           $(".panel-box .session-clean .badge").css({ right : 5 });
           $(".user-box img").css({"marginLeft" : "0px"});
       }
    }
    /* SELECT PAGE IN MENU */
    $(".sidebar ul a").each(function() {
        if($(this).attr("href") == location.href) {
            $(this).children("li").addClass("select-page");
            if($(this).parent("ul").hasClass("sub-menu")) {
               $(this).parent(".sub-menu")[0].style.display = 'block';
            }
        }
    });
    function lastTime() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "last-time"
            }
        });
    }
    function watchAccess() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "watch-access"
            },
            success: function(data) {
                if(data != '') {
                    location.href = "../home/";
                }
            }
        });
    }
});
    /* SHOW MESSAGE ON THE HEADER */
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
    /* CREATE NOTIFICATION */
    function createNotification(title, icon) {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "create-notification",
                text: title,
                "icon": icon
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }
    function pulseIcon() {
        var last = $("#pulse-icon").attr("href"),
        title = $("title").text();
        var c = setInterval(function() {
            if($("#pulse-icon").attr("href") != last) {
                $("#pulse-icon").attr("href", last);
                $("title").text(title);
            }
            else {
                $("#pulse-icon").attr("href", "/engine/templates/default/img/favicon-pulse.png");
                $("title").text("Вышел сигнал");
            }
        }, 700);
        setTimeout(function() {
            clearInterval(c);
            $("#pulse-icon").attr("href", last);
            $("title").text(title);
        }, 10000);
    }