$(document).ready(function() {
	$(document).keyup(function() {
		var act = document.activeElement,
			view = $(act).hasClass("pattern-text"),
			view2 = $(act).hasClass("content-box"),
			act = $(act).attr("data-id");
		if(view) {
			$(".content-box[data-id="+ act +"]").html($(".pattern-text[data-id="+ act +"]").val());
		}
		else if(view2) {
			//$(".pattern-text[data-id="+ act +"]").val($(".content-box[data-id="+ act +"]").html());
		}
	});
	$(".pattern-save").click(function() {
		var file = $(this).attr("data-file"),
			id = $(this).attr("data-id"),
            mess = $(".pattern-text[data-id="+ id +"]").val(),
            btn = $(this);
        if(mess != '') {
            $(btn).html("Сохранить <span class='glyphicon glyphicon-refresh loader'></span>");
            $.ajax({
                url: "../index.php?page=ajax&ajax-handle=patterns",
                type: "POST",
                data: {
                    "action" : "change-pattern",
                    "file": file,
                    "message": mess
                },
                success: function(data) {
                    if(data == 'success') {
                        showMessage("Шаблон был успешно сохранен");
                    }
                    else if(data == 'empty') {
                        showMessage("Пожалуйста, заполните все обязательные поля");
                    }
                    else {
                        showMessage("Произошла ошибка при сохранении шаблона");
                    }
                    $(btn).html("Сохранить");
                },
                fail: function() {
                    showMessage("Проверьте соединение с интернетом");
                    $(btn).html("Сохранить");
                }
            });
        }
        else {
            showMessage("Пожалуйста, заполните все обязательные поля");
        }
	});
});