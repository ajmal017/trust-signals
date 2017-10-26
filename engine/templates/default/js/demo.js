$(document).ready(function() {
    var lasttime = 10,
        cInt,
        isFirstUpdate = true;
    if(getCookie("demo-lasttime")) {
        if(typeof parseInt(getCookie("demo-lasttime")) == "number") {
            lasttime = parseInt(getCookie("demo-lasttime"));
            init();
        }
        else {
            lasttime = 0;
            removeCookie("demo-lasttime");
            setCookie("demo-lasttime", 0, {"expires":3600*24*30*12});
            update();
        }
    }
    else {
        removeCookie("demo-lasttime");
        setCookie("demo-lasttime", 10, {"expires":3600*24*30*12});
        lasttime = 10;
    }
    $(".start-btn").click(function() {
        init();
    });
    function init() {
        update();
        cInt = setInterval(dec, 60000);
        setInterval(update, 30000);
        setInterval(repeatInts, 1000);
    }
    function update() {
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=demo",
            type: "POST",
            success: function(data) {
                var bidLock = $(".bid").text();
                if($(".bid").text() != $(data).find(".bid").text()) {
                    if(!isFirstUpdate) {
                        sound();
                    }
                }
                $(".eurusd").html(data);
                repeatInts();
                if(bidLock != $(data).find(".bid").text()) {
                    if(!isFirstUpdate) {
                        var wrap = $(".icon");
                        $(wrap).addClass("new-signal");
                    }
                }
                else {
                    $(".geticon .icon").remove();
                    $(".geticon img").remove();
                    $(".description").text('ожидайте выход сигнала');
                    $(".geticon").prepend('<img src="http://trust-signals.com/engine/templates/default/img/log-2.gif">');
                }
                changeIcon();
                isFirstUpdate = false;
            },
            fail: function() {
                console.log("Network error");
            }
        });
    }
    function repeatInts() {
        var ints = rand(0, 9) + "" + rand(1, 9);
        $(".prefix").html(ints);
    }
    function rand(min, max)
    {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function changeIcon() {
        setTimeout(function() {
            $(".geticon .icon").remove();
            $(".geticon img").remove();
            $(".geticon").prepend('<img src="http://trust-signals.com/engine/templates/default/img/log-2.gif">');
            $(".description").text('ожидайте выход сигнала');
        }, 10000);
    }
    function clearClass(el) {
        setTimeout(function() {
            el.removeClass("new-signal");
        }, 5000);
    }
    function sound() {
        $("#audio")[0].play();
    }
    function dec() {
        if(lasttime - 1 < 0) {
            clearInterval(cInt);
        }
        else {
            lasttime--;
            removeCookie("demo-lasttime");
            setCookie("demo-lasttime", lasttime, {"expires":3600*24*30*12});
        }
    }
});