$(document).ready(function() {
    $("input[name=autotime]").change(function() {
        if($(this).prop("checked")) {
            $("#apply-time").attr("disabled", "disabled");
            $.ajax({
                "url": "../index.php?page=ajax&ajax-handle=users",
                "method": "POST",
                data: {
                    "action": "get-time"
                },
                success: function(data) {
                    $("#apply-time").val(data);
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        else {
            $("#apply-time").removeAttr("disabled").val("");
        }
    });
    var num = 6;
    /* INIT STYLES */
    $('select').styler();
    $('.apply-user-signal-btn').tooltip();
    progressCenter();
    $(window).resize(progressCenter);
    $(".open-users").click(function() {
        setTimeout(progressCenter, 30);
        $('.pie_progress').asPieProgress('start');
    });
    /* LOAD MORE */
    $(".load-more-information").click(function() {
        $(".load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=users",
            type: "POST",
            data: {
                action: 'load-signals',
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
                    $("#users .user-signal:last").after(data);
                    $("*[data-toggle=tooltip]").tooltip();
                    $('.pie_progress').asPieProgress({
                        namespace: 'asPieProgress',
                        size: 160,
                        speed: 15, // speed of 1/100
                        barcolor: '#fff',
                        barsize: '4',
                        trackcolor: '#f00',
                        fillcolor: 'none',
                        easing: 'ease',
                        numberCallback: function(n) {
                            var percentage = Math.round(this.getPercentage(n));
                            return percentage + '%';
                        },
                        contentCallback: null
                    });
                    progressCenter();
                    $('.pie_progress').asPieProgress('start');
                }
                num += 4;
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
    /* APPLY */
    $(".apply-user-signal-form").click(function() {
        var time = $("#apply-time").val(),
            time_exp = $("#apply-time-exp").val(),
            pos = $("#apply-pos").val(),
            symbol = $("#apply-symbol").val();
        $(".apply-user-signal-form").html('<span class="glyphicon glyphicon-ok"></span> Добавить сигнал ' + "<span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            "url": "../index.php?page=ajax&ajax-handle=users",
            "method": "POST",
            data: {
                action: "add-signal",
                "time": time,
                "time-exp": time_exp,
                "symbol": symbol,
                "pos": pos
            },
            success: function(data) {
                if(data == 'data') {
                    showMessage("Ошибка при добавлении сигнала");
                }
                else if(data == 'empty') {
                    showMessage("Заполните все необходимые поля");
                }
                else if(data == 'format') {
                    showMessage("Неправильный формат заполнения времени");
                }
                else {
                    var lastId = $("#users .user-signal:first").attr("id");
                    if(lastId != $(data).attr("id")) {
                        $("#"+$(data).attr("id")).remove();
                        if($("#users .user-signal").length > 0) {
                            $(data).prependTo("#users");
                            $("*[data-toggle=tooltip]").tooltip();
                        }
                        else {
                            $("#users").html(data);
                            $("*[data-toggle=tooltip]").tooltip();
                        }
                        num++;
                        $('.pie_progress').asPieProgress({
                            namespace: 'asPieProgress',
                            size: 160,
                            speed: 15, // speed of 1/100
                            barcolor: '#fff',
                            barsize: '4',
                            trackcolor: '#f00',
                            fillcolor: 'none',
                            easing: 'ease',
                            numberCallback: function(n) {
                                var percentage = Math.round(this.getPercentage(n));
                                return percentage + '%';
                            },
                            contentCallback: null
                        });
                        progressCenter();
                        $('.pie_progress').asPieProgress('start');
                    }
                    showMessage("Сигнал был успешно добавлен");
                }

                $("#apply-time").val("");
                $("#apply-time-exp").val("");
                $(".apply-user-signal-form").html('<span class="glyphicon glyphicon-ok"></span> Добавить сигнал');
            },
            fail: function() {
                $(".apply-user-signal-form").html('<span class="glyphicon glyphicon-ok"></span> Добавить сигнал');
                showMessage("При голосовании произошла ошибка");
            }
        });
    });
    /* SET VOTE */
    $("#users").on("click", ".user-signal-like", function() {
        var id = $(this).closest(".user-signal").attr('data-id');
        setVotes(id, 1);
    });
    $("#users").on("click", ".user-signal-dislike", function() {
        var id = $(this).closest(".user-signal").attr('data-id');
        setVotes(id, 0);
    });
    /* UPLOAD SIGNALS */
    setInterval(updateSignals, 15000);
    $('.pie_progress').asPieProgress({
        namespace: 'asPieProgress',
        size: 160,
        speed: 15, // speed of 1/100
        barcolor: '#fff',
        barsize: '4',
        trackcolor: '#f00',
        fillcolor: 'none',
        easing: 'ease',
        numberCallback: function(n) {
            var percentage = Math.round(this.getPercentage(n));
            return percentage + '%';
        },
        contentCallback: null
    });

    function setVotes(id, vote) {
        $("#user-signal-" + id + " .pie_progress__number").html("<span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            "url": "../index.php?page=ajax&ajax-handle=users",
            "method": "POST",
            data: {
                "action": "vote",
                "id": id,
                "vote": vote
            },
            success: function(data) {
                if(data != 'empty') {
                    $("#user-signal-" + id).html();
                    document.getElementById("user-signal-" + id).outerHTML = data;
                    $("*[data-toggle=tooltip]").tooltip();
                    $('#user-signal-'+id+' .pie_progress').asPieProgress({
                        namespace: 'asPieProgress',
                        size: 160,
                        speed: 15, // speed of 1/100
                        barcolor: '#fff',
                        barsize: '4',
                        trackcolor: '#f00',
                        fillcolor: 'none',
                        easing: 'ease',
                        numberCallback: function(n) {
                            var percentage = Math.round(this.getPercentage(n));
                            return percentage + '%';
                        },
                        contentCallback: null
                    });
                    $('.pie_progress').asPieProgress('start');
                    progressCenter();
                }
                else {
                    $("#user-signal-" + id + " .pie_progress__number").html("0%");
                    showMessage("При голосовании произошла ошибка");
                }
            },
            fail: function() {
                $("#user-signal-" + id + " .pie_progress__number").html("0%");
                showMessage("Проверьте соединение с интернетом");
            }
        });
    }

    function progressCenter() {
        var marginLeft = Math.abs($(".title-signal").width()) / 2 - 100;
        $(".rate-bar").css("margin-left", marginLeft + "px");
        var mL = $("#content").width() / 2 - $(".load-more-information").width() / 2;
        $(".load-more-information").css("margin-left", mL + 'px');
    }
    function updateSignals() {
        $.ajax({
            "url": "../index.php?page=ajax&ajax-handle=users",
            "method": "POST",
            data: {
                "action": "upload"
            },
            success: function(data) {
                if(data != 'empty' || data != '') {
                    var lastId = $("#users .user-signal:first").attr("id");
                    if(lastId != $(data).attr("id")) {
                        pulseIcon();
                        if($("#users .user-signal").length > 0) {
                            $(data).prependTo("#users");
                            $("*[data-toggle=tooltip]").tooltip();
                        }
                        else {
                            $("#users").html(data);
                            $("*[data-toggle=tooltip]").tooltip();
                        }
                        sound();
                        showMessage("Получен сигнал от пользователя");
                        num++;
                        $('.pie_progress').asPieProgress({
                            namespace: 'asPieProgress',
                            size: 160,
                            speed: 15, // speed of 1/100
                            barcolor: '#fff',
                            barsize: '4',
                            trackcolor: '#f00',
                            fillcolor: 'none',
                            easing: 'ease',
                            numberCallback: function(n) {
                                var percentage = Math.round(this.getPercentage(n));
                                return percentage + '%';
                            },
                            contentCallback: null
                        });
                        progressCenter();
                        $('.pie_progress').asPieProgress('start');
                    }
                }
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
            }
        });
    }
    function sound() {
        if(getCookie("cabinet-user-sound") != 'off') {
            $("#audio-users")[0].play();
        }
    }
});