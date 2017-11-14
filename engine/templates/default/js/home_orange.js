$(window).load(function() {
	closeLoader();
});
function closeLoader() {
	$(".preloader").fadeOut(300, function() {
		$(this).remove();
	});
}
$(document).ready(function() {
	var loc = "https://" + document.domain + "/";
	$(".close-preloader").show();
	$(".close-preloader").click(function() {
		closeLoader();
	});

	/* REGISTRATION */
	$(".reg-btn").click(function() {

		var btn = $(this),
			btnVal = $(this).html();

		$(btn).html("<span class='fa fa-spin fa-spinner'></span> " + btnVal);

		var name = $("#reg-name").val(),
			email = $("#reg-email").val(),
			pass = $("#reg-password").val(),
			pass2 = $("#reg-password2").val(),
			word = $("#reg-word").val(),
			sex = $("#reg-sex").val();
		if($("#reg-rules").prop("checked")) {
			$.ajax({
				"method": "POST",
				"url": loc+"index.php?page=ajax&ajax-handle=home",
				"data": {
					"email": email,
					"name": name,
					"word": word,
					"sex": sex,
					"password": pass,
					"password-repeat": pass2,
					"action": "reg"
				},
				success: function(data) {
					if(data == 'data') {
						showMessage("Вы заполнили не все поля");
					}
					else if(data == 'email') {
						showMessage("E-mail указан неверно");
					}
					else if(data == 'pass1') {
						showMessage("Пароли не совпадают");
					}
					else if(data == 'pass2') {
						showMessage("Пароль должен состоять из 8 или более символов");
					}
					else if(data == 'email2') {
						showMessage("Пользователь с таким E-mail адресом уже зарегистрирован в системе");
					}
					else {
						showMessage("Регистация прошла успешно", 1);
						location.href = loc + "cabinet/";
						$("#reg-name").val("");
						$("#reg-email").val("");
						$("#reg-password").val("");
						$("#reg-password2").val("");
						$("#reg-word").val("");
						$("#reg-sex").val("");
					}
					$(btn).html(btnVal);
				},
				fail: function() {
					showMessage("Проверьте соединение с интернетом");
					$("#reg-name").val("");
					$("#reg-email").val("");
					$("#reg-password").val("");
					$("#reg-password2").val("");
					$("#reg-word").val("");
					$("#reg-sex").val("");
					$(btn).html(btnVal);
				}
			});
		}
		else {
			showMessage("Для регистрации необходимо согласится с правилами сервиса");
			$(btn).html(btnVal);
		}
	});

	/* AUTH */
	$(".auth-btn").click(function() {
		var btn = $(this),
			btnVal = $(this).html();

		$(btn).html("<span class='fa fa-spin fa-spinner'></span> " + btnVal);

		var email = $("#auth-email").val(),
			pass = $("#auth-password").val();

		$.ajax({
			"method": "POST",
			"url": loc + "index.php?page=ajax&ajax-handle=home",
			"data": {
				"email": email,
				"password": pass,
				"action": "auth"
			},
			success: function(data) {
				if(data == 'success') {
					showMessage("Авторизация прошла успешно", 1);
					location.href = loc + "cabinet/";
				}
				else {
					showMessage("Вы ввели неверную информацию, проверьте Ваши данные и попробуйте снова");
				}
				$("#auth-email").val("");
				$("#auth-password").val("");
				$(btn).html(btnVal);
			},
			fail: function() {
				showMessage("Проверьте соединение с интернетом");
				$("#auth-email").val("");
				$("#auth-password").val("");
				$(btn).html(btnVal);
			}
		});
	});
	/* RECOVERY */
	$(".recovery-password").click(function() {
		var email = $("#auth-email2").val(),
			word = $("#auth-word").val();

		var btn = $(this),
			btnVal = $(this).html();

		$(btn).html("<span class='fa fa-spin fa-spinner'></span> " + btnVal);

		$.ajax({
			"method": "POST",
			"url": loc + "index.php?page=ajax&ajax-handle=home",
			"data": {
				"email": email,
				"word": word,
				"action": "recovery"
			},
			success: function(data) {
				if(data == 'data') {
					showMessage("Произошла ошибка при изменении пароля");
				}
				else {
					if(data == 'error') {
						showMessage("Вы ввели неверную информацию, проверьте Ваши данные и попробуйте снова");
					}
					else if(data == 'not-mail') {
						showMessage("Произошла серверная ошибка. Пароль не был изменен по причине неисправности системы");
					}
					else {
						showMessage("Новый пароль успешно выслан на адрес " + email, 1);
					}
				}
				$("#auth-email2").val("");
				$(btn).html(btnVal);
			},
			fail: function() {
				showMessage("Проверьте соединение с интернетом");
				$("#auth-email2").val("");
				$(btn).html(btnVal);
			}
		});
	});

	$(".to-top").click(function() {
		$("body").animate({"scrollTop" : "0px"}, 300);
	});
	$(".window .to-rules").click(function() {
		$(".window").fadeOut(300,function() {
			$(".remember-pass").hide();
			$(".window-rules").fadeIn(300, function() {
				$(".window-animate").css({
					"transform": "scale(1) translateY(0)",
					"opacity": "1"
				});
			});
		});
		$(".window-animate").css({
			"transform": "scale(.3) translateY(-100px)",
			"opacity": "0"
		});
	});
	$(".window .to-auth").click(function() {
		$(".window").fadeOut(300,function() {
			$(".remember-pass").hide();
			$(".window-auth").fadeIn(300, function() {
				$(".window-animate").css({
					"transform": "scale(1) translateY(0)",
					"opacity": "1"
				});
			});
		});
		$(".window-animate").css({
			"transform": "scale(.3) translateY(-100px)",
			"opacity": "0"
		});
	});
	$(".window .rem-pass").click(function() {
		$(".window .remember-pass").slideDown(300, function() {
			$(".window-auth").animate({"scrollTop" : 200 + "px"}, 300);
		});
	});
	$(".open-rules").click(function(e) {
		$(".window-rules").fadeIn(300, function() {
			$(".window-animate").css({
				"transform": "scale(1) translateY(0)",
				"opacity": "1"
			});
		});
	});
	$(".open-auth").click(function(e) {
        $("#content-window").hide();
        $(".box-header").hide();


		$(".window-auth").fadeIn(300, function() {
			$(".window-animate").css({
				"transform": "scale(1) translateY(0)",
				"opacity": "1"
			});
		});
	});
	$(".open-reg").click(function(e) {

		$(".window-reg").fadeIn(300, function() {
            $("#content-window").hide();
            $(".box-header").hide();

			$(".window-animate").css({
				"transform": "scale(1) translateY(0)",
				"opacity": "1"
			});
		});
	});
	$(".window-close").click(function() {
		$(".window").fadeOut(300,function() {
			$(".remember-pass").hide();
            $("#content-window").show();
            $(".box-header").show();
		});
		$(".window-animate").css({
			"transform": "scale(.3) translateY(-100px)",
			"opacity": "0"
		});
	});
	var optionsUp = {
	  useEasing : true,
	  useGrouping : true,
	  separator : '',
	  decimal : '',
	  prefix : '',
	  suffix : ''
	};
	$("header, section").waypoint(function(e, d) {
		if($(this).hasClass("about")) {
			new countUp("int-1", 0, Number($("#int-1").text()), 0, 2.5, optionsUp).start();
			new countUp("int-2", 0, Number($("#int-2").text()), 0, 2.5, optionsUp).start();
			new countUp("int-3", 0, Number($("#int-3").text()), 0, 2.5, optionsUp).start();
			new countUp("int-4", 0, Number($("#int-4").text()), 0, 2.5, optionsUp).start();
		}
		$(this).find(".animate").css({
			"opacity" : "1",
			"transform" : "translateX(0) translateY(0) scale(1) rotateX(0) rotateY(0)",
			"clip" : "rect(0px 500px 500px 0px)"
		});
	}, { "offset" : "80%" });

	var priceCalc = 1,
		daysCalc = 1;
	$(".calculate-summ").change(function() {
		var v = $(this).val();
		$(".nav-value-summ").text(v);
		priceCalc = v;
		calc(priceCalc, daysCalc);
	});

	$(".calculate-days").change(function() {
		var v = $(this).val();
		$(".nav-value-days").text(v);
		daysCalc = v;
		calc(priceCalc, daysCalc);
	});

	$(".calculate-days").ionRangeSlider({
		min: 1,
		max: 10
	});

	$(".calculate-summ").ionRangeSlider({
		min: 1,
		max: 100
	});

	$('[data-toggle="tooltip"]').tooltip();

	$("a").click(function(e) {
		if($(this).attr("href") == "#") {
			e.preventDefault();
		}
	});

	function calc(price, days) {
		var p = 1.2,
			a = price,
			ash = a*1,
			n = 53,
			d = days,
			g = n * d,
			stepen = Math.pow(p, g),
			b = 160,
			s1 = a * n * d,
			max = 53000,
			max2 = 100,
			h2 = 10,
			s3 = s1 / dep * days;

		var dep = price * h2 / max2,
			prof = dep * days;

		$(".graph-white").css("height", dep + "px");
		$(".graph-orange").css("height", prof + "px");

		$(".graph-result").text(s1);
	}

	var isOpen = false;
	$(".header-open").click(function() {
		if(!isOpen) {
			$(".header-menu").slideDown(300);
			isOpen = true;
		}
		else {
			$(".header-menu").slideUp(300);
			isOpen = false;
		}
	});

	$(".header-carousel").owlCarousel({
		slideSpeed : 300,
		paginationSpeed : 400,
		items : 1
	});

	initSlider(3, 30, 5200);

	function initSlider(size, p, speed) {
		var maxHeight = 0,
			amount = 0;
		$(".android-comment").each(function() {
			amount++;
			if($(this).height() > maxHeight) {
				maxHeight = $(this).height();
			}
		});

		$(".android-comment").css({
			"height" : maxHeight + p + "px"
		});
		$(".android-absolute").css({
			"position" : "absolute",
			"top" : "0"
		});
		$(".android-messages").css({
			"overflow" : "hidden",
			"height" : (maxHeight + p) * size + "px",
			"width" : "100%",
			"display" : "inline-block",
			"position" : "relative"
		});
		var top = 0;
		setInterval(function() {
			console.log(top + " - " + (maxHeight * (amount - size + 1)));
			if(top < (maxHeight * (amount - size + 1))) {
				top += (maxHeight + p);
				$(".android-absolute").animate({
					"top" : - top + "px"
				}, 300);
			}
			else {
				$(".android-absolute").animate({
					"top" :"0px"
				}, 300);
				top = 0;
			}
		}, speed);
	}

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