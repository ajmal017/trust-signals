$(document).ready(function() {
    setInterval(changeTime, 60000);
    
    function changeTime() {
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=vip",
            data: {
                action: "change-time"
            },
            success: function(data) {
                if(data != 'error') {
                    data = JSON.parse(data);
                    if(data.answer == 'over') {
                        $("#content").html(data.text);
                        $(".timeleft-vip").text("0 дней 00:00");
                    }
                    else {
                        if(data.answer == 'normal') {
                            $(".timeleft-vip").text(data.text);
                        }
                    }
                }
            }
        });
    }
});