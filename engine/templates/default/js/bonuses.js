$(document).ready(function() {
	$(".get-key").click(function(e) {
		e.preventDefault();
		$("#bonus-key").val(getKey());
	})
	$("body").on("click", ".remove-bonus", function(e) {
		if(confirm("Вы хотите удалить данный ключ?")) {
			var id = $(this).attr("data-id");
			$(".page-name").html("Скидочная система <span class='glyphicon glyphicon-refresh loader'></span>");
			$.ajax({
				url: "../index.php?page=ajax&ajax-handle=bonuses",
				type: "POST",
				data: {
					action: "remove",
					"id": id
				},
				success: function(data) {
					if(data == 'error') {
						showMessage("Произошла ошибка при удалении");
					}
					else {
						$(".bonuses-list").html(data);
					}
					$(".page-name").html("Скидочная система");
				},
				fail: function() {
					showMessage("Проверьте соединение с интернетом");
					$(".page-name").html("Скидочная система");
				}
			});
		}
	});
	$(".bonus-add").click(function(e) {
		var key = $("#bonus-key").val(),
			percent = $("#bonus-percent").val();
		$(".page-name").html("Скидочная система <span class='glyphicon glyphicon-refresh loader'></span>");
		$.ajax({
			url: "../index.php?page=ajax&ajax-handle=bonuses",
			type: "POST",
			data: {
				action: "add",
				"key": key,
				"percent" : percent
			},
			success: function(data) {
				if(data == 'key') {
					showMessage("Такой бонусный ключ уже сущевствует");
				}
				else {
					$(".bonuses-list").html(data);
				}
				$(".page-name").html("Скидочная система");
				$("#bonus-key").val("");
				$("#bonus-percent").val("");
			},
			fail: function() {
				showMessage("Проверьте соединение с интернетом");
				$(".page-name").html("Скидочная система");
			}
		});
	});
	/* SWITCH */
	$("#bonus-module").change(function() {
		var val = $(this).prop("checked");
		val = val == false ? 0 : 1;
		var word = val == 0 ? "выключен" : "включен";
		$(".page-name").html("Скидочная система <span class='glyphicon glyphicon-refresh loader'></span>");
		$.ajax({
			url: "../index.php?page=ajax&ajax-handle=bonuses",
			type: "POST",
			data: {
				action: "module",
				"val": val
			},
			success: function(data) {
				console.log(data);
				if(data == 'success') {
					showMessage("Модуль 'Бонус' " + word);
				}
				else {
					showMessage("Произошла ошибка при настройке опции");
				}
				$(".page-name").html("Скидочная система");
			},
			fail: function() {
				showMessage("Проверьте соединение с интернетом");
				$(".page-name").html("Скидочная система");
			}
		});
	});
});
function b64EncodeUnicode(str) {
	return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
		return String.fromCharCode('0x' + p1);
	}));
}
function rand(min, max) {
	return Math.round(Math.random() * (max - min) + min);
}
function getKey() {
	var key = b64EncodeUnicode(rand(1111, 99999));
	return key;
}