$(document).ready(function() {
    var id = null,
        isBtn = false;
    /* ADD */
    var button32 = $("#add-news-img");
    new AjaxUpload(button32, {
        name: "add-news",
        action: "../index.php?page=ajax&ajax-handle=notification",
        hoverClass: "",
        onSubmit: function(file, ext) {
            if(ext == "jpg" || ext == "png" || ext == "jpeg") {
                button32.html("<span class='glyphicon glyphicon-refresh loader'></span> Загрузка");
            }
            else {
                showMessage("Изображение должно быть форматов jpeg или png");
            }
        },
        onComplete: function(file, response) {
            if(response == "types") {
                showMessage("Изображение должно быть форматов jpeg или png");
            }
            else if(response == "size") {
                showMessage("Размер изображения должен быть не более 500Кб");
            }
            else {
                id = response;
                isBtn = true;
                showMessage("Продолжайте заполнять информацию :)");
                $("#add-news").removeClass("disabled");
            }
            button32.html('<span class="glyphicon glyphicon-picture"></span> Загрузить картинку');
        }
    });
    $("#add-news").click(function() {
        var title = $("#news-title").val(),
            desc = CKEDITOR.instances['news-desc'].getData(),
            btn = $(this),
            bt = $(btn).html();
        if(isBtn && title != '' && desc != '') {
            $(btn).html('<span class="glyphicon glyphicon-refresh loader"></span> Сохранить');
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    "action": "add-news-full",
                    "id": id,
                    "text": desc,
                    "title": title
                },
                success: function(data) {
                    if(data == 'empty') {
                        showMessage("Заполните все поля");
                        btn.text(bt);
                    }
                    else if (data == "error") {
                        showMessage("Произошла ошибка при сохранении");
                        btn.text(bt);
                    }
                    else {
                        showMessage("Новость была успешно добавлена");
                        btn.text(bt);
                        $("#news-url").val(data);
                        $("#news-url-box").slideDown(200);
                    }
                    btn.html(bt);
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    btn.text(bt);
                }
            });
        }
        else {
            showMessage("Заполните все поля");
        }
    });
});