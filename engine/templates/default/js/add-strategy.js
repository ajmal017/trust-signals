var id = null,
    isBtn = false;
$(document).ready(function() {
    if(document.location.href.search(/strs_/) != '-1') {
        $("#tabs-list").remove();
    }
    $("#add-strategy").click(function() {
        var title = $("#strategy-title").val(),
            desc = CKEDITOR.instances['strategy-desc'].getData(),
            type = $("#type-of-strategy").val(),
            btn = $(this),
            bt = $(btn).html();
        if(isBtn && title != '' && desc != '' && ( type == 'vip' || type == 'cabinet' )) {
            $(btn).html('<span class="glyphicon glyphicon-refresh loader"></span> Сохранить');
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=notification",
                type: "POST",
                data: {
                    "action": "add-strategy-full",
                    "id": id,
                    "text": desc,
                    "title": title,
                    "type" : type
                },
                success: function(data) {
                    if(data == 'success') {
                        showMessage("Стратегия была успешно добавлена");
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
        }
        else {
            showMessage("Заполните все поля");
        }
    });
});
/* ADD */
var button = $("#add-strategy-img");
new AjaxUpload(button, {
    name: "add-strategy",
    action: "../index.php?page=ajax&ajax-handle=notification",
    hoverClass: "",
    onSubmit: function(file, ext) {
        if(ext == "jpg" || ext == "png" || ext == "jpeg") {
            button.html("<span class='glyphicon glyphicon-refresh loader'></span> Загрузка");
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
            $("#add-strategy").removeClass("disabled");
        }
        button.html('<span class="glyphicon glyphicon-picture"></span> Загрузить картинку');
    }
});