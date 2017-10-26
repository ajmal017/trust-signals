/* IMG */
var button = $("#load-img-news");
var idImg = button.attr("data-id");
new AjaxUpload(button, {
    name: "img-news",
    action: "../index.php?page=ajax&ajax-handle=notification",
    hoverClass: "",
    data : {
        "id" : idImg
    },
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
            showMessage("Изменения прошли успешно");
        }
        button.html('<span class="glyphicon glyphicon-picture"></span> Загрузить картинку');
    }
});