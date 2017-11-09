$(document).on( "click", "#supp-btn", function() {
    $("#supp-btn").html("Отправить <span class='fa fa-spin fa-spinner'></span>");
    var subject = $("#supp-subject").val(),
        text = $("#supp-text").val(),
        name = $("#supp-name").val(),
        email = $("#supp-email").val();

    $.ajax({
        method: "POST",
        url: "/index.php?page=ajax&ajax-handle=home",
        data: {
            action: "send",
            "subject": subject,
            "text": text,
            "name": name,
            "email": email,
            "code" : grecaptcha.getResponse()
        },
        success: function(data) {
            $("#supp-text").val("");
            $("#supp-name").val("");
            $("#supp-email").val("");
            $("#supp-subject").val("");
            $("#supp-btn").html("Отправить");
            if(data == 'success') {
                showMessage("Сообщение было отправлено", 1);
            }
            else if(data == 'format') {
                showMessage("Поле E-mail указано неверно");
            }
            else if(data == 'captcha') {
                showMessage("Подтвердите что вы не робот");
            }
            else if(data == 'empty') {

                showMessage("Заполните все необходимые поля");
            }
            else if(data == 'data') {
                showMessage("Ошибка перевода данных");
            }
            grecaptcha.reset();
        },
        fail: function() {
            showMessage("Проверьте соединение с интернетом");
            $("#supp-btn").html("Отправить");
            $("#supp-text").val("");
            $("#supp-name").val("");
            $("#supp-email").val("");
            $("#supp-subject").val("");
            grecaptcha.reset();
        }
    });
});

$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();

	var num = 10;
	$(".news-full-box .arloadmore").click(function() {
		$.ajax({
			url: "/index.php?page=ajax&ajax-handle=notification",
			type: "POST",
			data: {
				action: 'load-news',
				n : num
			},
			success:function(data){
				if(data == 'empty') {
					showMessage("Записей больше нет");
				}
				else if(data == 'data') {
					showMessage("Ошибка перевода данных");
				}
				else {
					$("#strategies-list").append(data);
					num += 10;
				}
			},
			fail:function(){
				showMessage("Проверьте соединение с интернетом");
			}
		});
	});
	$(".menu li").each(function() {
		if($(this).find("a").attr("href") == location.href) {
			$(this).addClass("active");
		}
	});
	$(".open-menu").click(function() {
		var $menu = $(".menu");
		console.log($menu[0].style);
		if($menu[0].style.display == "none" || $menu[0].style.display == "") {
			$menu.slideDown(300);
		}
		else {
			$menu.slideUp(300);
		}
	});
	$(".address-arrow").click(function() {
		var $menu = $(".address-gray");
		console.log($menu[0].style);
		if($menu[0].style.display == "none" || $menu[0].style.display == "") {
			$menu.slideDown(300);
			$(this).find(".fa").removeClass("fa-arrow-down").addClass("fa-arrow-up");
		}
		else {
			$menu.slideUp(300);
			$(this).find(".fa").removeClass("fa-arrow-up").addClass("fa-arrow-down");
		}
	});
});

function showMessage(message, succ) {
	var s = "";
	if(succ == 1) {
		s = 'success';
	}
	if($(".alert-message").length > 0) {
		$(".alert-message").text(message);
	}
	else {
		$("<div class='alert-message " + s + "'>"+ message +"</div>").appendTo("body");
		$(".alert-message").slideDown(300);
		setTimeout(function() {
			$(".alert-message").animate({"height":"0px"}, 300, function() {
				$(".alert-message").remove();
			});
		}, 3000);
	}
}