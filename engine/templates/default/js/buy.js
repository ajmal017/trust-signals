$(document).ready(function() {
	if(location.href.search(/buy\_mobile\//) != -1) {
		$(".pay-system-item").click(function() { $("#order-pay").modal("show") });
		$("body").on("click", "#generation-link", function() { $("#order-pay").modal("hide") });
	}
	$(".promocode-text").keyup(function() {
		var val = $(this).val();
		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=buy",
			data: {
				action: "checkpromo",
				"key": val
			},
			success: function(data) {
				if(data == "error" || data == "" || data == "auth") {
					$(".promocode-wrap").removeClass("has-success").addClass("has-error");
					$(".promocode-icon-true").css("opacity", 0);
					$(".promocode-icon-false").css("opacity", 1);
					$(".promocode-desc").html("");
				}
				else {
					$(".promocode-wrap").removeClass("has-error").addClass("has-success");
					$(".promocode-icon-false").css("opacity", 0);
					$(".promocode-icon-true").css("opacity", 1);
					$(".promocode-desc").html("Поздравляю! Вы получите скидку "+data+"%");
				}
			},
			fail: function() {
				showMessage("Проверьте соединение с интернетом");
			}
		});
	});
	var isSuccess = true,
		isSelect = false;
	$("body").on("click", ".pay-system-item", function() {
		isSelect = true;
		$(".pay-system-item-select").each(function() {
			$(this).removeClass("pay-system-item-select");
		});
		$("#generation-link").removeClass("disabled");
		$(this).addClass("pay-system-item-select");
		$("#open-pay-systems").attr("data-system", $(this).attr("data-system"));
		$("#open-pay-systems").attr("data-pay-system", $(this).attr("data-pay-system"));
	});
	$("body").on("click", "#generation-link", function() {
		if(isSuccess && isSelect) {
			 var summ = $("#open-pay-systems").attr("data-summ"),
				 id = $("#open-pay-systems").attr("data-package"),
				 system = $("#open-pay-systems").attr("data-system"),
				 paySystem = $("#open-pay-systems").attr("data-pay-system");
			 $(".page-name").html("Список пакетов <span class='glyphicon glyphicon-refresh loader'></span>");
			 if(system == 'other') {
				if(paySystem == 'neteller') {
					$(".modal-backdrop").remove();
					$("#neteller-system").modal("show");
				}
				else if(paySystem == 'yandexmoney') {
					$(".modal-backdrop").remove();
					$("#yandex-system").modal("show");
				}
				else if(paySystem == 'skrill') {
					$(".modal-backdrop").remove();
					$("#skrill-system").modal("show");
				}
				else if(paySystem == 'paypal') {
					$(".modal-backdrop").remove();
					$("#paypal-system").modal("show");
				}
				else {
					showMessage("Ошибка при попытке оплаты");
				}
				$(".page-name").html("Список пакетов");
				isSuccess = true;
			 }
			 else {
				var promo = "";
				if($(".promocode-text").length) {
					promo = $(".promocode-text").val();
				}
				 $.ajax({
					 method: "POST",
					 url: "../index.php?page=ajax&ajax-handle=buy",
					 data: {
						 action: "redirect",
						 "summ": summ,
						 "package": id,
						 "system": system,
						 "pay-system": paySystem,
						 "promo" : promo
					 },
					 beforeSend: function() {
						isSuccess = false;
					 },
					 success: function(data) {
						 if(data != 'error') {
						     location.href = data;
						 }
						 else {
							showMessage("Ошибка при попытке оплаты");
						 }
						 $(".page-name").html("Список пакетов");
						 isSuccess = true;
					 },
					 fail: function() {
						 showMessage("Проверьте соединение с интернетом");
						 $(".page-name").html("Список пакетов");
						 isSuccess = true;
					 }
				 });
			}
		}
		else {
			showMessage("Выберете платежную систему");
		}
	});
	$("body").on("click", ".buy-button", function() {
		var summ = $(this).attr("data-summ"),
			id = $(this).attr("data-package"),
			type = $(this).attr("data-type");
		$("#systems-summ, .systems-summ").text(summ);
		$("#systems-type, .systems-type").text(type.toUpperCase());
		$("#open-pay-systems").hide(0);
		$(".promocode-show").hide();
		if(type == "vip" || type == "vip1") {
			$(".promocode-show").show();
		}
		$("#open-pay-systems").attr("data-summ", summ).attr("data-package", id).attr("data-type", type);
		$("body").animate({scrollTop:0}, 300, function() {
			$("#open-pay-systems").slideDown(300);
		});
	});
});