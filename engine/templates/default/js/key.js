$(document).ready(function() {
    $(".check-key").click(function() {
        var key = $("#key").val();
        $(".key-title").html("Введите ключ <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=key",
            method: "POST",
            data: {
                "action": "key",
                "key": key
            },
            success: function(data) {
                if(data == 'error') {
                    showMessage("Ошибка при вводе ключа");
                    $(".key-title").html("Введите ключ");
                }
                else {
                    $(".timeleft-cabinet").text(data);
                    showMessage("Ключ введен верно, Вы получили бесплатные минуты");
                    $(".key-title").html("Введите ключ");
                }
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $(".key-title").html("Введите ключ");
            }
        });
    });
});