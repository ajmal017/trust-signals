$(document).ready(function() {
    /* EDIT */
    $("#edit-news").click(function() {
        var title = $("#edit-news-title").val(),
            text = CKEDITOR.instances['edit-news-desc'].getData(),
            btn = $(this),
            bt = btn.text(),
            id = btn.attr("data-id");
        btn.html(bt + " <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "../index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                "action": "news-edit",
                "id": id,
                "text": text,
                "title": title
            },
            success: function(data) {
                if(data == 'success') {
                    showMessage("Новость была успешно сохранена");
                    btn.text(bt);
                }
                else if(data == 'empty') {
                    showMessage("Заполните все поля");
                    btn.text(bt);
                }
                else {
                    showMessage("Произошла ошибка при сохранении");
                    btn.text(bt);
                }
                btn.html(bt);
            },
            fail: function() {
                showMessage("Проверьте соединение с интернетом");
                btn.text(bt);
            }
        });
    });
    /* FULL IMG */
    $("body").on("click", ".open-img", function() {
        var img = $(this).attr("data-img"),
            title = $(this).attr("data-title");
        $("#img-modal-full").attr("src", img);
        $("#article-modal").text(title);
    });
    /* REMOVE STRATEGIES */
    $("#content").on("click", ".remove-news", function(e) {
        if(confirm("Вы хотите удалить данныую новость?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "/index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    action : 'remove-news',
                    "id" : id
                },
                success:function(data){
                    added = false;
                    if(data == 'error') {
                        showMessage("Ошибка при попытке удалить новость");
                    }
                    else if(data == 'success') {
                        showMessage("Новость была успешно удалена");
                        $("#str-id-" + id).css({
                            "background" : "#FA5555",
                            "color" : "#fff"
                        });
                        $("#str-id-" + id + " .moder-panel").remove();
                        $("#str-id-" + id + " .btn.btn-info").remove();
                    }
                    else {
                        showMessage("Ошибка при попытке удалить стратегию");
                    }
                },
                fail:function(){
                    showMessage("Проверьте соединение с интернетом");
                }
            });
        }
        e.preventDefault();
    });
    /* LOAD */
    var num = 10;
    $(".news-full-box .load-more-information").click(function() {
        $(".news-full-box .load-more-information .load-text").html("Загрузить ещё <span class='glyphicon glyphicon-refresh loader'></span>");
        $.ajax({
            url: "/index.php?page=ajax&ajax-handle=notification",
            type: "POST",
            data: {
                action: 'load-news',
                n : num
            },
            success:function(data){
                if(data == 'empty') {
                    $(".news-full-box .load-more-information .load-text").text("Записей больше нет");
                }
                else if(data == 'data') {
                    showMessage("Ошибка перевода данных");
                    $(".news-full-box .load-more-information .load-text").text("Загрузить ещё");
                }
                else {
                    $(".news-full-box .load-more-information .load-text").text("Загрузить ещё");
                    $("#strategies-list").append(data);
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