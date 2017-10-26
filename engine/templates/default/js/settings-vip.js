$(document).ready(function() {
    /* SETTINGS */
    var standartValue = 25;
    if(getCookie("inv") == 'on') {
        $("#inv-switch").addClass("active");
        $("#inv-switch").attr("aria-pressed", "true");
        $("#inv-switch").html('Выключить инверсию');
        $(".inv-is-on").show();
    }
    if(getCookie("vip-sound") == 'off') {
        $("#vip-signals-button").addClass("active");
        $("#vip-signals-button").attr("aria-pressed", "true");
        $("#vip-signals-button").html('<span class="glyphicon glyphicon-volume-off"></span> VIP сигналы');
    }
    if(getCookie("vip-news-sound") == 'off') {
        $("#news-signals-button").addClass("active");
        $("#news-signals-button").attr("aria-pressed", "true");
        $("#news-signals-button").html('<span class="glyphicon glyphicon-volume-off"></span> Экономические новости');
    }
    $("#inv-switch").click(function() {
        if(!$(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).attr("aria-pressed", "false");
            $(this).html('Выключить инверсию');
            setCookie("inv", "on", {"expires":3600*24*30*12});
            $(".inv-is-on").show();
        }
        else {
            $(this).addClass("active");
            $(this).attr("aria-pressed", "true");
            $(this).html('Включить инверсию');
            setCookie("inv", "off", {"expires":3600*24*30*12});
            $(".inv-is-on").hide();
        }
    });
    $("#vip-signals-button").click(function() {
        if(!$(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).attr("aria-pressed", "false");
            $(this).html('<span class="glyphicon glyphicon-volume-off"></span> VIP сигналы');
            setCookie("vip-sound", "off", {"expires":3600*24*30*12});
        }
        else {
            $(this).addClass("active");
            $(this).attr("aria-pressed", "true");
            $(this).html('<span class="glyphicon glyphicon-volume-up"></span> VIP сигналы');
            setCookie("vip-sound", "on", {"expires":3600*24*30*12});
        }
    });
    $("#news-signals-button").click(function() {
        if(!$(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).attr("aria-pressed", "false");
            $(this).html('<span class="glyphicon glyphicon-volume-off"></span> Экономические новости');
            setCookie("vip-news-sound", "off", {"expires":3600*24*30*12});
        }
        else {
            $(this).addClass("active");
            $(this).attr("aria-pressed", "true");
            $(this).html('<span class="glyphicon glyphicon-volume-up"></span> Экономические новости');
            setCookie("vip-news-sound", "on", {"expires":3600*24*30*12});
        }
    });
    if(getCookie("vip-power") != 'undefined')
        standartValue = getCookie("vip-power");
    $("#power-of-signals").change(function() {
        if(getCookie("vip-switch") != "2" && getCookie("vip-switch") != "3") {
            setCookie("vip-power", $(this).val(), {"expires":3600*24*30*12});
        }
        else {
            showMessage("Сила сигнала не может быть регулируемая при сигналах в 15-30 минут");
        }
    });
    $("#power-of-signals").ionRangeSlider({
        min: 25,
        max: 100,
        from: standartValue
    });
    $(".open-settings").click(function(e) {
        $(".setting-box").show();
        e.preventDefault();
    });
    $(".close-settings").click(function() {
        $(".setting-box").hide();
    });
});