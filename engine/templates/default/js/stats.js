$(document).ready(function() {
    $("body").on("click", "#start-calculate", function() {
        var summ = $("#summ-value").val();
        $("#start-calculate").html("Посчитать <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            method: "POST",
            url: "../index.php?page=ajax&ajax-handle=stats",
            data: {
                action: "calculate",
                "summ": summ
            },
            success: function(data) {
                if(data == 'data') {
                    showMessage("Ошибка при обработке данных");
                }
                else {
                    var deposit = (data.split(";"))[1],
                        profit = (data.split(";"))[0],
                        string = "<p><span class='glyphicon glyphicon-saved'></span> Депозит: "+ deposit +"$</p>"+"<p><span class='glyphicon glyphicon-credit-card'></span> Прибыль: "+ profit +"$</p>";
                    $(".calc-result").html(string);
                }
                $("#start-calculate").html("Посчитать");
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                $("#start-calculate").html("Посчитать");
            }
        });
    });
});