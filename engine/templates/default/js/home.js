new WOW().init();
$(document).ready(function() {
	if(document.location.href == "http://trust-signals.com/new/") {
		document.cookie = "old=0; expires=-1; path=/";
	}
    scrollerCounter();
    var isScrollCount = false;
    var loc = "/";
    /* INIT STYLES */
    stylers();
    $(window).resize(stylers);
    $("*[data-toggle=tooltip]").tooltip();
    $("select").styler();
    $("div").on("click", ".to-bottom-rules", function() {
        $("body").animate({
            "scrollTop": $(document).height() - $(window).height() +"px"
        }, 400, function() {
            $(".rules-link").addClass("new-signal");
            setTimeout(function() {
                $(".rules-link").removeClass("new-signal");
            }, 5000);
        });
    });
    $(".rules-link").click(function() {
        $(".rules-link").removeClass("new-signal");
    });
    $('input[type=checkbox]').each(function() {
        $(this).prettyCheckable({});
    });
    $(".recovery-btn").click(function() {
        $(".wrap-recovery").slideDown(300);
    });
    /* PARALLAX */
    $(window).scroll(function() {
        var st = $(window).scrollTop();
        $(".header-content").css({
            "transform":"translate(0%, -" + st / 2 + "%)"
        });
        $(".line-parallax").css({
            "transform":"translate(0%, " + st / 40 + "%)"
        });
        $(".big-line .line-parallax").css({
            "background-position":"0 -" + st / 30 + "%"
        });
    });
    /* STYLER */
    function stylers() {
        if($(window).width() < 965) {
            $(".why-desc").css("padding-left", 10);
        }
        else {
            $(".why-desc").css("padding-left", 100)
        }
        if($(window).width() < 580) {
            $(".header .header-title").css("font-size", 40);
            $(".header-description").css({"padding" : "10px 20px", "font-size":15});
        }
        else {
            $(".header .header-title").css("font-size", 70);
            $(".header-description").css({"padding" : "10px 120px", "font-size":18});

        }
    }
    function scrollerCounter() {
        var options = {
              useEasing : true,
              useGrouping : true,
              separator : '',
              decimal : '',
              prefix : '',
              suffix : ''
            };
        $(window).scroll(function() {
            if($(window).scrollTop() > ($(".four-list").offset().top - ($(window).height() - 100)) && !isScrollCount) {
                var val1 = Number($("#integer1").text());
                var val2 = Number($("#integer2").text());
                var val3 = Number($("#integer3").text());
                var val4 = Number($("#integer4").text());
                
                var box1 = new countUp("integer1", 0, val1, 0, 4, options);
                var box2 = new countUp("integer2", 0, val2, 0, 4, options);
                var box3 = new countUp("integer3", 0, val3, 0, 4, options);
                var box4 = new countUp("integer4", 0, val4, 0, 4, options);
                
                box1.start();
                box2.start();
                box3.start();
                box4.start();

                isScrollCount = true;
            }
        });
    }
    /* REGISTRATION */
    $(".reg-btn").click(function() {
        var name = $("#reg-name").val(),
            email = $("#reg-email").val(),
            pass = $("#reg-password").val(),
            pass2 = $("#reg-password2").val(),
            word = $("#reg-word").val(),
            sex = $("#reg-sex").val();
        if($("#reg-rules").prop("checked")) {
            $("#reg-label").html("Регистрация <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                "method": "POST",
                "url": loc+"index.php?page=ajax&ajax-handle=home",
                "data": {
                    "email": email,
                    "name": name,
                    "word": word,
                    "sex": sex,
                    "password": pass,
                    "password-repeat": pass2,
                    "action": "reg"
                },
                success: function(data) {
                    if(data == 'data') {
                        showMessage("Вы заполнили не все поля");
                    }
                    else if(data == 'email') {
                        showMessage("E-mail указан неверно");
                    }
                    else if(data == 'pass1') {
                        showMessage("Пароли не совпадают");
                    }
                    else if(data == 'pass2') {
                        showMessage("Пароль должен состоять из 8 или более символов");
                    }
                    else if(data == 'email2') {
                        showMessage("Пользователь с таким E-mail адресом уже зарегистрирован в системе");
                    }
                    else {
                        showMessage("Регистация прошла успешно");
                        location.href = loc + "cabinet/";
                        $("#reg-name").val("");
                        $("#reg-email").val("");
                        $("#reg-password").val("");
                        $("#reg-password2").val("");
                        $("#reg-word").val("");
                        $("#reg-sex").val("");
                    }
                    $("#reg-label").html("Регистрация");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $("#reg-name").val("");
                    $("#reg-email").val("");
                    $("#reg-password").val("");
                    $("#reg-password2").val("");
                    $("#reg-word").val("");
                    $("#reg-sex").val("");
                    $("#reg-label").html("Регистрация");
                }
            });
        }
        else {
            showMessage("Для регистрации необходимо согласится с правилами сервиса");
        }
    });
    /* AUTH */
    $(".auth-btn").click(function() {
        var email = $("#auth-email").val(),
            pass = $("#auth-password").val();
        $("#auth-label").html("Авторизация <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            "method": "POST",
            "url": loc + "index.php?page=ajax&ajax-handle=home",
            "data": {
                "email": email,
                "password": pass,
                "action": "auth"
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Авторизация прошла успешно");
                    location.href = loc + "cabinet/";
                }
                else {
                    showMessage("Вы ввели неверную информацию, проверьте Ваши данные и попробуйте снова");
                }
                $("#auth-email").val("");
                $("#auth-password").val("");
                $("#auth-label").html("Авторизация");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#auth-email").val("");
                $("#auth-password").val("");
                $("#auth-label").html("Авторизация");
            }
        });
    });
    /* RECOVERY */
    $(".recovery-password").click(function() {
        var email = $("#auth-email2").val(),
            word = $("#auth-word").val();
        $("#auth-label").html("Авторизация <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            "method": "POST",
            "url": loc + "index.php?page=ajax&ajax-handle=home",
            "data": {
                "email": email,
                "word": word,
                "action": "recovery"
            },
            success: function(data) {
                if(data == 'data') {
                    showMessage("Произошла ошибка при изменении пароля");
                }
                else {
                    if(data == 'error') {
                        showMessage("Вы ввели неверную информацию, проверьте Ваши данные и попробуйте снова");
                    }
                    else if(data == 'not-mail') {
                        showMessage("Произошла серверная ошибка. Пароль не был изменен по причине неисправности системы");
                    }
                    else {
                        showMessage("Новый пароль успешно выслан на адрес " + email);
                    }
                }
                $("#auth-email2").val("");
                $("#auth-word").val("");
                $("#auth-label").html("Авторизация");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#auth-email2").val("");
                $("#auth-word").val("");
                $("#auth-label").html("Авторизация");
            }
        });
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
});