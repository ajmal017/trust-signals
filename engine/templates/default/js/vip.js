$(document).ready(function() {
    /* SWITCH */
    var cSwitch = Number(getCookie("vip-switch")),
        cSwitch = cSwitch == 2 || cSwitch == 3 ? cSwitch : 1,
        intervalChart = 1;
    if(cSwitch) {
        if(cSwitch == 2) {
            intervalChart = 15;
            $(".power-signal-wrapper-pow").hide();
        }
        else if(cSwitch == 3) {
            intervalChart = 30;
            $(".power-signal-wrapper-pow").hide();
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
        if(getCookie("inv") == 'off') {
        var tmpSpan;
        $(".switch-minutes button").each(function(e) {
            $(this).find("span").remove();
            $(this).removeClass("disabled");
            removeCookie("vip-switch");
        });
        $(this).append("<span class='select-element-switch glyphicon glyphicon-ok'></span>");
        $(this).addClass("disabled");
        setCookie("vip-switch", $(this).attr("data-id"), { expires : 3600 * 24 * 365 });

        if($(this).attr("data-id") == 2) {
            intervalChart = 15;
            $(".power-signal-wrapper-pow").hide();
        }
        else if($(this).attr("data-id") == 3) {
            intervalChart = 30;
            $(".power-signal-wrapper-pow").hide();
        }
        else {
            intervalChart = 1;
            $(".power-signal-wrapper-pow").show();
        }

        }
        else {
            showMessage("Для переключения режима выключите инверсию");
        }
    });
    /* INCLUDES QUOTES */
    $("input[name='quotes-list']").change(function() {
        $("#quotes-vip-list-title").html("Валютные пары <span class='glyphicon glyphicon-refresh loader'></span>");
        if($(this).prop("checked")) {
            changeQuotes("add-match-to-list", $(this).val());
            var id = $(this).val();
            $("#signals-box").append("<div id='"+id+"' class='col-md-4 wrapper-signals'</div>");
        }
        else {
            var id = $(this).val();
            $("#" + id).remove();
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
                $("#quotes-vip-list-title").html("Валютные пары");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#quotes-vip-list-title").html("Валютные пары");
            }
        });
    }
    /* BAR STYLES */
    $("body").on("click", ".new-signal", function() {
        $(this).removeClass("new-signal");
    });
    setInterval(getNews, 30000);
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
            url: "../index.php?page=ajax&ajax-handle=vip",
            data: {
                action: "update-signals"
            },
            success: function(data) {
                data = JSON.parse(data);
                for(var i in data) {
                    var name = i,
                        answer = data[name].answer,
                        tmp = data[name].tmp,
                        id = $(tmp).attr("data-id"),
                        icon = $(tmp).attr("data-icon"),
                        title = $(tmp).attr("data-title"),
                        lastId = $("#" + name + " div:first").attr('data-id'),
                        wrap = $("#" + name);
                    if(answer == 'empty') {
                        wrap.html(tmp);
                    }
                    else {
                        if(answer == 'success') {
                            if(lastId != id) {
                                wrap.html(tmp);
                                deleteTimer(name);
                                sound();
                                pulseIcon();
                                showMessage(title);
                                $("*[data-toggle=tooltip]").tooltip();
                                wrap.addClass("new-signal");
                                clearClass(wrap);
                                createNotification(title, icon);
                                reloadStylesProgressBar();
                            }
                        }
                    }
                }
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
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

    function getNews() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=vip",
            data: {
                action: "get-news"
            },
            success: function(data) {
                var lastId = $(".news-box:first").attr('data-id'),
                    id = $(data).attr("data-id");
                $(".news-append").html(data);
                if(lastId != id) {
                    if(id != 0) {
                        showMessage("Внимание скоро выйдет новость");
                        soundNews();
                        $("*[data-toggle=tooltip]").tooltip();
                    }
                }
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }

    function clearClass(el) {
        setTimeout(function() {
            el.removeClass("new-signal");
        }, blinkAmount);
    }
    function soundNews() {
        if(getCookie("vip-news-sound") != 'off') {
            $("#audio-news")[0].play();
        }
    }
    function sound() {
        if(getCookie("vip-sound") != 'off') {
            $("#audio-vip")[0].play();
        }
    }
});