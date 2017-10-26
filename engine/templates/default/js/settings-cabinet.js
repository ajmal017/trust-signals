$(document).ready(function() {
    /* SETTINGS */
    var standartValue = 25;
    if(getCookie("cabinet-sound") == 'off') {
        $("#basic-signals-button").addClass("active");
        $("#basic-signals-button").attr("aria-pressed", "true");
        $("#basic-signals-button").html('<span class="glyphicon glyphicon-volume-off"></span> Базовые сигналы');
    }
    if(getCookie("cabinet-user-sound") == 'off') {
        $("#user-signals-button").addClass("active");
        $("#user-signals-button").attr("aria-pressed", "true");
        $("#user-signals-button").html('<span class="glyphicon glyphicon-volume-off"></span> Сигналы от пользователей');
    }
    $("#basic-signals-button").click(function() {
        if(!$(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).attr("aria-pressed", "false");
            $(this).html('<span class="glyphicon glyphicon-volume-off"></span> Базовые сигналы');
            setCookie("cabinet-sound", "off", {"expires":3600*24*30*12});
        }
        else {
            $(this).addClass("active");
            $(this).attr("aria-pressed", "true");
            $(this).html('<span class="glyphicon glyphicon-volume-up"></span> Базовые сигналы');
            setCookie("cabinet-sound", "on", {"expires":3600*24*30*12});
        }
    });
    $("#user-signals-button").click(function() {
        if(!$(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).attr("aria-pressed", "false");
            $(this).html('<span class="glyphicon glyphicon-volume-off"></span> Сигналы от пользователей');
            setCookie("cabinet-user-sound", "off", {"expires":3600*24*30*12});
        }
        else {
            $(this).addClass("active");
            $(this).attr("aria-pressed", "true");
            $(this).html('<span class="glyphicon glyphicon-volume-up"></span> Сигналы от пользователей');
            setCookie("cabinet-user-sound", "on", {"expires":3600*24*30*12});
        }
    });
    if(getCookie("cabinet-power") != 'undefined')
        standartValue = getCookie("cabinet-power");
    $("#power-of-signals").change(function() {
        setCookie("cabinet-power", $(this).val(), {"expires":3600*24*30*12});
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