$(document).ready(function(){
    var basic = "EUR/USD",
        low = "eurusd",
        intsb = $(".basic-signal").attr("data-ints"),
        iArb = JSON.parse(intsb),
        mins = 1,
        blinkAmount = 8000,
        intervalChart = 1;


    try {
    	var iArb = JSON.parse(intsb);
    }
    catch(e) {
    	var iArb = [0,0,0,0,0,0,0,0,0,0];
    }

    setInterval(history, 60000);

    function history() {
        $.ajax({
            method: "POST",
            url: "/index.php?page=ajax&ajax-handle=elly",
            data: {
                action: "history"
            },
            success: function(data) {
                $(".history").html(data);
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }

    if(getCookie("elly-res") == 'on') {
        $(".reswitch").html('<span class="fa fa-toggle-off"></span> Выключить автопереключение');
    }

    $(".reswitch").click(function() {
        if($(".reswitch span").hasClass("fa-toggle-off")) {
            $(".reswitch").html('<span class="fa fa-toggle-on"></span> Включить автопереключение');
            setCookie("elly-res", "off", {"expires":3600*24*30*12});
        }
        else {
            $(".reswitch").html('<span class="fa fa-toggle-off"></span> Выключить автопереключение');
            setCookie("elly-res", "on", {"expires":3600*24*30*12});
        }
    });

    /* SWITCH */
    var cSwitch = Number(getCookie("elly-switch"));
    var cSwitch = cSwitch == 2 || cSwitch == 3 ? cSwitch : 1;
    if(cSwitch) {
        if(cSwitch == 2) {
            intervalChart = 15;
            mins = 15;
        }
        else if(cSwitch == 3) {
            intervalChart = 30;
            mins = 30;
        }
        else {
            intervalChart = 1;
            mins = 1;
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
                removeCookie("elly-switch");
            });
            $(this).append("<span class='select-element-switch glyphicon glyphicon-ok'></span>");
            $(this).addClass("disabled");
            setCookie("elly-switch", $(this).attr("data-id"), { expires : 3600 * 24 * 365 });

            if($(this).attr("data-id") == 2) {
                intervalChart = 15;
                mins = 15;
            }
            else if($(this).attr("data-id") == 3) {
                intervalChart = 30;
                mins = 30;
            }
            else {
                intervalChart = 1;
                mins = 1;
            }
    });

    setTimeout(timer,1000);
    getChart(iArb[0],iArb[1],iArb[2],iArb[3],iArb[4],iArb[5],iArb[6],iArb[7],iArb[8],iArb[9]);

    signalsUpdate();
    setInterval(signalsUpdate, 30000);

    $("#content").on("click", ".google-plus-graph", function() {
        var symbol = basic.split("/"),
            symbol = symbol[0]+symbol[1];
        reinetNews(symbol, intervalChart);
    });

    $("#content").on("click", ".signal-mini", function() {
        $(this).removeClass("new-signal");
        var symbol = $(this).attr("data-symbol"),
            lower = $(this).attr("data-lower"),
            lasttime = $(this).attr("data-lasttime"),
            time1 = $(this).attr("data-time1"),
            time2 = $(this).attr("data-time2"),
            closed = $(this).attr("data-closed"),
            description = $(this).attr("data-description"),
            pos = $(this).attr("data-pos"),
            color = $(this).attr("data-color"),
            ints = $(this).attr("data-ints"),
            up = $(this).attr("data-up"),
            down = $(this).attr("data-down");
        try {
	    	var iAr = JSON.parse(ints);
	    }
	    catch(e) {
	    	var iAr = [0,0,0,0,0,0,0,0,0,0];
	    }

        $(".basic-signal").attr("data-ints", ints);
        $(".basic-signal").attr("data-symbol", symbol);
        $(".basic-signal .lasttime-signal").html(lasttime);
        $(".basic-signal .highlight").removeClass("bg-green").removeClass("bg-red").removeClass("bg-yellow").addClass("bg-"+color);
        $(".basic-signal .time-1").html(time1);
        $(".basic-signal .time-2").html(time2);
        $(".basic-signal .basic-closed").html(closed);
        $(".basic-signal .basic-symbol").html(symbol);
        $(".basic-signal .basic-description").html(description);
        $(".basic-signal .basic-pos").html(pos);
        $(".indecator-call").css("width", up + "%").text(up + "% CALL");
        $(".indecator-put").css("width", down + "%").text(down + "% PUT");
        $(".select-symbol").text(symbol);
        low = lower;
        basic = symbol;
        getChart(iAr[0],iAr[1],iAr[2],iAr[3],iAr[4],iAr[5],iAr[6],iAr[7],iAr[8],iAr[9]);
        timer();
    });

    function signalsUpdate() {
        $.ajax({
            method: "POST",
            url: "/index.php?page=ajax&ajax-handle=elly",
            data: {
                action: "update-signals"
            },
            success: function(data) {
                try {
                    data = JSON.parse(data);
                    var isStep = false,
                        listSel = null;
                    for(var i in data) {
                        var name = i,
                            answer = data[name].answer,
                            tmp = data[name].tmp,
                            mini = data[name].mini,
                            closed = data[name].closed,
                            min1 = data[name].min1,
                            min2 = data[name].min2,
                            down = data[name].down,
                            up = data[name].up,
                            pos = data[name].pos,
                            symbol = data[name].symbol,
                            symbol_lower = data[name].symbol_lower,
                            miniBox = $(".signal-mini[data-lower=" + name + "]"),
                            fullBox = $(".basic-signal");

                            try {
                                var integers = JSON.parse("["+data[name].integers+"]");
                            } catch (e) {
                                var integers = JSON.parse("[0,0,0,0,0,0,0,0,0,0]");
                            }

                        if(answer == 'error') {
                            // error
                        }
                        else {
                            if(answer == 'success') {
                                if(name == low) {
                                    $(".indecator-call").css("width", up + "%").text(up + "% CALL");
                                    $(".indecator-put").css("width", down + "%").text(down + "% PUT");
                                    if(fullBox.attr("data-closed") != closed) {
                                        if(down > 0 || up > 0) {
                                            sound(symbol_lower, mins, pos);
                                            isStep = true;
                                        }
                                        fullBox[0].outerHTML = tmp;
                                    }
                                    getChart(integers[0],integers[1],integers[2],integers[3],integers[4],integers[5],integers[6],integers[7],integers[8],integers[9]);
                                }
                                if(miniBox.attr("data-closed") != closed) {
                                    pulseIcon();
                                    miniBox[0].outerHTML = mini;
                                    if(down > 0 || up > 0) {
                                        $(".signal-mini[data-lower=" + name + "]")[0].classList.add("new-signal");
                                        clearClass($(".signal-mini[data-lower=" + name + "]")[0]);
                                        if(listSel == null) {
                                            listSel = {"down" : down, "up" : up, "symbol" : symbol, "pos" : pos, "box" : tmp, "integers" : integers, "symbolLower" : symbol_lower, "mins" : mins};
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(!isStep && getCookie("elly-res") == 'on') {
                        if(listSel != null) {
                            sound(listSel.symbolLower, listSel.mins, listSel.pos);
                            $(".basic-signal")[0].outerHTML = listSel.box;
                            low = listSel.symbolLower;
                            basic = listSel.symbol;
                            $(".select-symbol").text(basic);
                            $(".indecator-call").css("width", listSel.up + "%").text(listSel.up + "% CALL");
                            $(".indecator-put").css("width", listSel.down + "%").text(listSel.down + "% PUT");
                            timer();
                            getChart(listSel.integers[0], listSel.integers[1], listSel.integers[2], listSel.integers[3], listSel.integers[4], listSel.integers[5], listSel.integers[6], listSel.integers[7], listSel.integers[8], listSel.integers[9]);
                        }
                    }
                }
                catch(e) {
                    console.log("err");
                }
            },
            fail: function() {
                showMessage("Проверьте подключение к интернету");
            }
        });
    }

    function clearClass(el) {
        setTimeout(function() {
            el.classList.remove("new-signal");
        }, blinkAmount);
    }

    function timer(){
        var obj = document.getElementById('timer_inp');
        if(obj != null) {
            if(obj.innerHTML == 0) { return; }
            obj.innerHTML--;
            if (obj.innerHTML== 0 ){
                obj.innerHTML = 0;
                setTimeout(function(){},1000);
            } else {
                setTimeout(timer,1000);
            }
        }
    }

    function reinetNews(symbol, interval) {
        $(".news-box-symbol").text(symbol.toUpperCase());
        new TradingView.widget({
            "height" : "530",
            "symbol": "FX:"+symbol.toUpperCase(),
            "interval": interval,
            "timezone": "UTC",
            "theme": "Black",
            "style": "1",
            "toolbar_bg": "#f1f3f6",
            "hide_top_toolbar": true,
            "save_image": false,
            "hideideas": true,
            "studies": [ "MACD@tv-basicstudies",
                "StochasticRSI@tv-basicstudies",
                "MASimple@tv-basicstudies"
            ],
            "container_id": "news-box"
        });
    }

    function getChart(b1, b2, b3, b4, b5, b6, b7, b8, b9, b10) {
        $(function() {
            var d1 = [ [1, b1],[2, b2], [3, b3], [4, b4], [5, b5],[6, b6], [7, b7], [8, b8], [9, b9], [10, b10]];
            var options = {
                series: {
                    lines: {
                        show: true, fill: false, lineWidth:2, fillColor: { colors: [ { opacity: 0 }, { opacity: 0}] }
                    },
                    points: {
                        show: true, fill: true, lineWidth:2, radius:2.5, fillColor: "rgba(0,0,0,0.3)"
                    },
                    shadowSize: 0
                },
                colors :["#fff"],
                grid: {
                    hoverable: true, color: "#fff", backgroundColor:"rgba(0,0,0,0.0)" ,borderWidth:1, borderColor:"rgba(255,255,255,0.3)", labelMargin:8
                },
                xaxis: {
                    show: false,
                    ticks: 12,
                    font: {
                        size: 9,
                        color: ["#fff"]
                    }
                },
                yaxis: {
                    ticks: 6,
                    font: {
                        size: 9,
                        color: ["#fff"]
                    }
                },
                legend: {
                    backgroundOpacity:0,
                    noColumns:2,
                    labelBoxBorderColor: "#fff"
                }
            };
            $.plot(".plot-chart-1", [ {data: d1} ], options);

        });
    }

});

function sound(symbol, min, pos) {
    var mp3 = "/engine/templates/default/elly/sound/"+symbol + "_" + min + "m_"+pos+".",
        wav = mp3 + "wav",
        ogg = mp3 + "ogg",
        mp3 = mp3 + "mp3";
        /*
        audio = new Audio();
    audio.src = mp3;
    audio.autoplay = true;*/
    $("#audio-box").remove();
    var audio = document.createElement("audio"),
        mp3Box = document.createElement("source"),
        wavBox = document.createElement("source"),
        oggBox = document.createElement("source");
    oggBox.setAttribute("src", ogg);
    mp3Box.setAttribute("src", mp3);
    wavBox.setAttribute("src", wav);
    audio.appendChild(oggBox);
    audio.appendChild(mp3Box);
    audio.appendChild(wavBox);
    audio.id = "audio-box";
    audio.autoplay = true;
    document.body.appendChild(audio);
    console.log("start audio");
}