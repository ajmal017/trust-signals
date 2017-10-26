$(document).ready(function() {
    /* LOAD */
    var num = 10;
    $(".load-more-information").click(function() {
        $(".load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-notifications',
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
                    $("#mails").append(data);
                    num += 10;
                }
            },
            fail:function(){
                showMessage("Проверьте соединение с интернетом");
                $(".load-more-information .load-text").html("Загрузить ещё");
            }
        });
    });
});