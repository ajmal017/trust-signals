$("iframe").each(function() {
    $(this).ready(function() {
        $(".loader-signal").fadeOut(500);
    });
});
$(document).ready(function() {
    var isOpenedWindow = false,
        intervalChart = 1;
    /* SWITCH */
    var cSwitch = Number(getCookie("cabinet-switch")),
        cSwitch = cSwitch == 2 || cSwitch == 3 ? cSwitch : 1;
    if(cSwitch) {

        if(cSwitch == 2) {
            intervalChart = 15;
        }
        else if(cSwitch == 3) {
            intervalChart = 30;
        }
        else {
            intervalChart = 1;
        }

        $(".switch-minutes button").each(function(e) {
            $(this).find("span").remove();
            $(this).removeClass("disabled");
        });
        $(".switch-minutes button[data-id="+ cSwitch +"]").addClass("disabled").append("<span class='select-element-switch glyphicon glyphicon-ok'></span>");
    }
    $(".switch-minutes button").click(function() {
        var tmpSpan;
        $(".switch-minutes button").each(function(e) {
            $(this).find("span").remove();
            $(this).removeClass("disabled");
            removeCookie("cabinet-switch");
        });
        $(this).append("<span class='select-element-switch glyphicon glyphicon-ok'></span>");
        $(this).addClass("disabled");
        setCookie("cabinet-switch", $(this).attr("data-id"), { expires : 3600 * 24 * 365 });

        if($(this).attr("data-id") == 2) {
            intervalChart = 15;
        }
        else if($(this).attr("data-id") == 3) {
            intervalChart = 30;
        }
        else {
            intervalChart = 1;
        }

        isOpenedWindow = false;
    });
    var daysWindow = Number($("#spam-days").text()); // кол-во дней
    document.cookie = "old=0; expires=-1; path=/";
    if(!getCookie("spamn") && $("#spam-checker").text() == 'ok') {
        $("#window-box").fadeIn(400, function() {
            sizingWindow();
        });
    }

    $("#window-over .window-close").click(function() {
        $("#window-over").fadeOut(300);
    });

    $("#window-box img").load(function() {
        sizingWindow();
    });

    $("#window-over img").load(function() {
        sizingWindowOver();
    });

    $(".window-close").click(function(e) {
        $("#window-box").fadeOut(400);
        setCookie("spamn", "1", { expires : 60 * 24 * daysWindow });
        e.preventDefault();
    });

    var sizingWindowOver = function() {
        var widthBrowser = $(window).width(),
            widthWindow = $("#window-over .window").width(),
            marginLeftWindow = widthBrowser / 2 - widthWindow / 2;
        $("#window-over.window-wrapper").css({
            "paddingLeft" : marginLeftWindow + "px"
        });
    };

    var sizingWindow = function() {
        var widthBrowser = $(window).width(),
            widthWindow = $("#window-box .window").width(),
            marginLeftWindow = widthBrowser / 2 - widthWindow / 2;
        $("#window-box.window-wrapper").css({
            "paddingLeft" : marginLeftWindow + "px"
        });
    };


    $("#change-quote").change(function() {
        var val = $(this).val();
        $("#chart-box-val").html("");
        $("#stast-signal .modal-body").text("Проверьте подключение к интернету");
        new TradingView.widget({
            "container_id": "chart-box-val",
            "locale": "ru",
            "autosize": true,
            "symbol": val,
            "interval": "1",
            "timezone": "Europe/Moscow",
            "theme": "white",
            "style": "1",
            "toolbar_bg": "#000000",
            "hide_side_toolbar": true,
            "allow_symbol_change": true,
            "hideideas": true,
            "studies": [ "MACD@tv-basicstudies",
                "StochasticRSI@tv-basicstudies",
                "MASimple@tv-basicstudies"
            ]
        });
    });
    /* BAR STYLES */
    setInterval(changeTime, 60000);
    reloadStylesProgressBar();
    /* INIT BASIC DATA */
    $("body").on("click", ".open-stats", function() {
        var symbol = $(this).attr("data-symbol"),
            title  = $(this).attr("data-title");
        $("#stast-signal h4.modal-title").text(symbol);
        $("#stast-signal .modal-body").text("Проверьте подключение к интернету");
        title = title == 'gold' ? "XAUUSD" : title;
        title = title == 'silver' ? "XAGUSD" : title;
        new TradingView.widget({
            "container_id": "chart-box-modal",
            "autosize": true,
            "symbol": "FX:" + title.toLowerCase(),
            "interval": intervalChart,
            "locale": "ru",
            "interval": "1",
            "timezone": "Europe/Moscow",
            "theme": "white",
            "style": "1",
            "toolbar_bg": "#000000",
            "hide_side_toolbar": true,
            "allow_symbol_change": true,
            "hideideas": true,
            "studies": [ "MACD@tv-basicstudies",
                "StochasticRSI@tv-basicstudies",
                "MASimple@tv-basicstudies"
            ]
        });
    });
    var blinkAmount = 15000,
        intervalUpdateSignals = 6000;
    /* UPLOAD SIGNALS */
    setInterval(updateSignals, intervalUpdateSignals);
    /* REMOVE STATUS NEW */
    $(".nav-pills > li > a").click(function() {
        $(this).removeClass("new-signal");
    });
    /* PROGRESS BAR */
    function reloadStylesProgressBar() {
        $(".progress-bar").each(function() {
            $(this).animate({
                "width" : $(this).attr("aria-valuenow") + "%"
            }, 200);
        });
    }
    /* UPLOAD SIGNALS */
    function updateSignals() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "update-signals"
            },
            success: function(data) {
                if(data != "signalsisover") {
                    data = JSON.parse(data);
                    var quotes_list = ["eurusd", "gbpusd", "gbpjpy"];
                    for(var i = 0; i < quotes_list.length; i++) {
                        var name = quotes_list[i],
                            answer = data[name].answer,
                            tmp = data[name].tmp,
                            id = $(tmp).attr("data-id"),
                            icon = $(tmp).attr("data-icon"),
                            title = $(tmp).attr("data-title"),
                            lastId = $("#" + name + " div:first").attr('data-id'),
                            wrap = $("#" + name);
                        if(answer == 'empty') {
                            wrap.html(tmp);
                            $("iframe").each(function() {
                                $(this).ready(function() {
                                    $(".loader-signal").fadeOut(500);
                                });
                            });
                        }
                        else {
                            if(answer == 'success') {
                                if(lastId != id) {
                                    if(lastId == undefined) {
                                        wrap.html(tmp);
                                        $("iframe").each(function() {
                                            $(this).ready(function() {
                                                $(".loader-signal").fadeOut(500);
                                            });
                                        });
                                    }
                                    else {
                                        var dataBox = data[name].dbox;
                                        $("#" + name + " .signal-wrapper").attr("data-id", dataBox.id);
                                        $("#" + name + " .signal-wrapper").attr("data-icon", dataBox.pos);
                                        $("#" + name + " .signal-wrapper").removeClass("signal-wrapper-up");
                                        $("#" + name + " .signal-wrapper").removeClass("signal-wrapper-down");
                                        $("#" + name + " .signal-wrapper").addClass("signal-wrapper-" + dataBox.pos);
                                        $("#" + name + " .signal-wrapper .signal-symbol span:first").removeClass("glyphicon-arrow-up");
                                        $("#" + name + " .signal-wrapper .signal-symbol span:first").removeClass("glyphicon-arrow-down");
                                        $("#" + name + " .signal-wrapper .signal-symbol span:first").addClass("glyphicon-arrow-" + dataBox.pos);
                                        $("#" + name + " .signal-wrapper .position-wrapper span").removeClass("label-up");
                                        $("#" + name + " .signal-wrapper .position-wrapper span").removeClass("label-down");
                                        $("#" + name + " .signal-wrapper .position-wrapper span").addClass("label-" + dataBox.pos);
                                        $("#" + name + " .position-wrapper span").text(dataBox.bid);
                                        $("#" + name + " .signal-wrapper .symbol-value").text(dataBox.symbol);
                                        $("#" + name + " .signal-wrapper .progress").attr("title", "Сила сигнала " + dataBox.interest + "%");
                                        $("#" + name + " .signal-wrapper .progress").attr("data-original-title", "Сила сигнала " + dataBox.interest + "%");
                                        $("#" + name + " .signal-wrapper .progress-bar").attr("aria-valuenow", dataBox.interest);
                                        $("#" + name + " .signal-wrapper .progress-bar").text(dataBox.interest + "%");
                                        $("#" + name + " .signal-wrapper .signal-time-one").text(dataBox.time1);
                                        $("#" + name + " .signal-wrapper .signal-time-second").text(dataBox.time2);
                                        $("#" + name + " .signal-wrapper .signal-money").text(dataBox.money);
                                        $("#" + name + " .signal-wrapper .pos-name-signal").text(dataBox.posname);
                                    }
                                    sound();
                                    pulseIcon();
                                    deleteTimer(name);
                                    showMessage(title);
                                    $("*[data-toggle=tooltip]").tooltip();
                                    $("a[href=#" + name + "-tab]").addClass("new-signal");
                                    setTimeout(function() {
                                        $("*").removeClass("new-signal");
                                    }, blinkAmount);
                                    createNotification(title, icon);
                                    reloadStylesProgressBar();
                                    /* SWITCH */
                                    var cSwitch = Number(getCookie("cabinet-switch"));
                                    if(cSwitch == 2 || cSwitch == 3) {
                                        updateAmountSignals(cSwitch);
                                    }
                                }
                            }
                        }
                    }
                }
                else {
                    if(!isOpenedWindow) {
                        $("#window-over").fadeIn(300, function() {
                            sizingWindowOver();
                            isOpenedWindow = true;
                        });
                    }
                }
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }

    function updateAmountSignals(type) {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "change-amount",
                "type" : type
            }
        });
    }

    function deleteTimer(name) {
        $("#" + name + " .box-timer").countdown360({
            radius      : 12,
            seconds     : 10,
            fontColor   : '#FFFFFF',
            autostart   : false,
            strokeWidth : 4,
            onComplete  : function () { $("#" + name + " .box-timer").html(""); }
        }).start();
    }

    function changeTime() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=cabinet",
            data: {
                action: "change-time"
            },
            success: function(data) {
                if(data != 'error') {
                    data = JSON.parse(data);
                    if(data.answer == 'over') {
                        $("#content").html(data.text);
                        $(".timeleft-cabinet").text("0 дней 00:00");
                    }
                    else {
                        if(data.answer == 'normal') {
                            $(".timeleft-cabinet").text(data.text);
                        }
                    }
                }
            }
        });
    }
    function sound() {
        if(getCookie("cabinet-sound") != 'off') {
            $("#audio-cabinet")[0].play();
        }
    }

});