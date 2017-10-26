$(document).ready(function() {
	var isUploaded = true,
		isCleared = true;
	var settings = {
		isRobotStarted : false,
		isSocketConnected: false,
		isSocketInitData: false,
		isUsedMartingale : true,
		isAfterMartingale : false,
		isUserMartingale : false,
		symbols : "",
		rate : 0,
		minPercent : 0,
		martingaleСoefficient : 2.3,
		numberOfKnees : 5,
		limitedDeal : 1,
		stopBalanceHigher : false,
		stopBalanceLower : false,
		socket: null,
		balance: 0,
		balanceType : "",
		percents: {},
		opening: {},
		sessionId: null,
		isDealOpenedBefore: true,
		timeout: null,
		timeoutValue: "",
		isClosedAllDeals: true,
		workedTime: 0,
		workedTimeInterval: null,
		algorithm : 1,
		timeExp : 1,
		isTokenFreedom : true
	};
	$(".web-demo-get").click(function(e) {
		e.preventDefault();
		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=web",
			data: {
				"action" : "demo"
			},
			success: function(data) {
				if(data == "success") {
					location.reload();
				}
			}
		});
	});
	$(".web-pair-checked").each(function() {
		settings.percents[$(this).val()] = Number($(this).attr("data-win"));
	});
	$(".web-set-kness").keyup(function() {
		var kness = Math.round(Number($(".web-set-kness").val())),
			template = "";
		if($(".web-set-martin").prop("checked") && kness < 3) {
			kness = 3;
		}
		else if($(".web-set-martin").prop("checked") && kness > 7) {
			kness = 7;
		}
		$(".web-user-list").html("");
		for(var i = 0; i < kness; i++) {
			var $tmp = $($("#web-template-user").html());
			$tmp.find(".number").html(i+2);
			$tmp.find('.web-martin-coef-item').attr("data-index", i + 1)
			$(".web-user-list").append($tmp);
		}
	});
	$(".web-set-timeout").change(function() {
		if($(this).prop("checked")) {
			$(".web-set-timeout-wrap").slideDown(300);
		}
		else {
			$(".web-set-timeout-wrap").slideUp(300);
		}
	});

	$(".web-set-martin").change(function() {
		if($(this).prop("checked")) {
			$(".web-set-martin-box").slideDown(300);
		}
		else {
			$(".web-set-martin-box").slideUp(300);
		}
	});
	$(".web-set-after-martin").change(function() {
		if($(this).prop("checked")) {
			$(".web-set-user-martin").removeAttr("checked");
			$(".web-set-user-martin + a").removeClass("checked");
			$(".web-user-list").slideUp(300);
			$(".web-set-kness").attr("placeholder", "от 3 до 30");
		}
	});
	$(".web-set-user-martin").change(function() {
		if($(this).prop("checked")) {
			$(".web-set-after-martin").removeAttr("checked");
			$(".web-set-after-martin + a").removeClass("checked");
			$(".web-user-list").slideDown(300);
			$(".web-set-kness").attr("placeholder", "от 3 до 7");
		}
		else {
			$(".web-set-kness").attr("placeholder", "от 3 до 30");
			$(".web-user-list").slideUp(300);
		}
	});
	function openDealPlatform(symbol, position, rate) {
		var date = Date.now(),
			sessionId = settings.sessionId == null ? generate() : settings.sessionId;
		var data = [{
			"data": [{
				"amount": rate,
				"duration": settings.timeExp * 60,
				"dir": position,
				"pair": symbol,
				"source": "platform",
				"group": settings.balanceType == "" ? "" : "demo",
				"timestamp": date
			}],
			"data_type": "deal_open",
			"event_name": "deals"+settings.balanceType+":opening",
			"uuid": sessionId,
			"timestamp": Math.round(date / 1000),
			"type": "request"
		}];
		settings.socket.send(JSON.stringify(data));
	}
	function closeDealOpened() {
		settings.isDealOpenedBefore = false;
		setTimeout(function() {
			settings.isDealOpenedBefore = true;
		}, 5000);
	}
	function openDeal(symbol, position, zero) {
		if(settings.isTokenFreedom || !settings.isTokenFreedom) {
			var uniqid = Date.now() * Math.random();
			if(settings.isSocketInitData) {
				if(typeof settings.opening[symbol] == "undefined") {
					if(settings.isClosedAllDeals) {
						if(settings.percents[symbol.toUpperCase()] >= settings.minPercent) {
							if(settings.limitedDeal > Object.keys(settings.opening).length) {
								settings.opening[symbol] = {
									"rate" : settings.rate,
									"position" : position,
									"knees" : 0,
									"open" : true,
									"zero" : false,
									"id" : uniqid
								};
								openDealPlatform(symbol, position, settings.rate);
								closeDealOpened();
								closeThenProcessed(symbol, uniqid);
								//closeToken(symbol, position, zero);
							}
						}
					}
				}
				else {
					if(settings.isUsedMartingale) {
						if(settings.opening[symbol].knees < settings.numberOfKnees) {
							if(!settings.opening[symbol].open) {
								if(settings.isUserMartingale !== false) {
									var index = settings.opening[symbol].knees + 1;
									if(typeof settings.isUserMartingale["x" + index] != "undefined")
										position = settings.isUserMartingale["x" + index];
								}
								if(typeof zero == "undefined" && !settings.opening[symbol].zero) {
									var coef = settings.martingaleСoefficient;
									var rate = Math.ceil(settings.opening[symbol].rate * coef);
									settings.opening[symbol].rate = rate;
									settings.opening[symbol].knees++;
								}
								settings.opening[symbol].id = uniqid;
								openDealPlatform(symbol, position, settings.opening[symbol].rate);
								closeDealOpened();
								closeThenProcessed(symbol, uniqid);
								//closeToken(symbol, position, zero);
							}
						}
						else {
							delete settings.opening[symbol];
						}
					}
				}
			}
		}
	}
	function closeToken(symbol, position, zero) {
		settings.isTokenFreedom = false;
		setTimeout(function() {
			settings.isTokenFreedom = true;
			openDeal(symbol, position, zero);
		}, rand(5, 8) * 1000);
	}
	function rand(min, max) {
		if(max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}
		else {
			return Math.floor(Math.random() * (min + 1));
		}
	}
	function robotTimeout(time) {
		if(settings.timeout != null)
			clearInterval(settings.timeout);
		settings.timeout = setInterval(function() {
			var now = new Date(),
				hours = now.getHours(),
				minutes = now.getMinutes();
				hours = hours > 9 ? hours : "0" + hours,
				minutes = minutes > 9 ? minutes : "0" + minutes,
				string = hours + ":" + minutes;
			if(string == time && !Object.keys(settings.opening).length)
				turnOff();
			else if(string == time) {
				settings.isClosedAllDeals = false;
			}
		}, 1000);
	}
	function closeThenProcessed(symbol, uniqid) {
		if(!settings.isAfterMartingale && !settings.isUserMartingale) {
			setTimeout(function() {
				if(typeof settings.opening[symbol] != "undefined") {
					if(settings.opening[symbol].id == uniqid) {
						delete settings.opening[symbol];
					}
				}
			}, settings.timeExp * 60 * 1000 + 1500);
		}
	}
	function turnOff() {
		if(settings.isRobotStarted) {
			settings.isRobotStarted = false;
			$(".web-robot-start").removeClass("fade-in");
			if(settings.isSocketConnected)
				settings.socket.close();
			settings.socket = null;
			settings.balance = 0;
			settings.isSocketConnected = false;
			settings.isSocketInitData = false;
			settings.isAfterMartingale = false;
			settings.isUserMartingale = false;
			settings.opening = {};
			settings.symbols = "";
			settings.martingaleСoefficient = 2.3;
			settings.numberOfKnees = 3;
			settings.limitedDeal = 1;
			settings.timeoutValue = "";
			settings.algorithm = 1;
			settings.timeExp = 1;
			$(".web-timeleft").html("00:00:00");
			$(".web-timeleft-title").html("Время работы:");
			clearInterval(settings.workedTimeInterval);
			settings.workedTime = 0;
			if(settings.timeout != null)
				clearInterval(settings.timeout);
			$(".web-balance").html("<i class='fa fa-spin fa-spinner'></i>");
			$(".web-type").html("<i class='fa fa-spin fa-spinner'></i>");
		}
	}
	$(".web-launch").click(function() {
		if(!settings.isRobotStarted) {
			var rate = Math.round(Number($(".web-set-rate").val()));
				minPercent = Math.round(Number($(".web-set-percent").val())),
				limited = Math.round(Number($(".web-set-limited").val())),
				coef = Number($(".web-set-coef").val()),
				kness = Math.round(Number($(".web-set-kness").val())),
				stopBalanceLower = Math.round(Number($(".web-set-lower").val())),
				stopBalanceHigher = Math.round(Number($(".web-set-higher").val())),
				hours = Math.round(Number($(".web-set-hours").val())),
				minutes = Math.round(Number($(".web-set-minutes").val()));
			if(limited == NaN || limited < 1)
				limited = 1;
			if(coef == NaN || coef == 0)
				coef = 2.3;
			if(kness == NaN || kness == 0)
				kness = 3;
			if(!$(".web-pair-checked:checked").length) {
				showMessage("Выберете одну или несколько валютных пар");
			}
			else if(rate <= 0 || rate == NaN) {
				showMessage("Укажите начальную ставку");
			}
			else if(minPercent < 0 || minPercent == NaN) {
				showMessage("Укажите минимальную прибль по паре");
			}
			else if($(".web-set-martin").prop("checked") && coef > 5 || coef < 2.3) {
				showMessage("Укажите правильный коэффициент Мартингейла");
			}
			else if($(".web-set-martin").prop("checked") && kness > 30 || kness < 3) {
				showMessage("Укажите правильное количество колен Мартингейла");
			}
			else if($(".web-set-timeout").prop("checked") && (hours < 0 || hours > 24 || minutes < 0 || minutes > 59 || $(".web-set-minutes").val() == "" || $(".web-set-hours").val() == "")) {
				showMessage("Укажите правильное время остановки робота");
			}
			else {
				var isUserMartingale = false;
				if($(".web-set-user-martin").prop("checked")) {
					var array = {};
					$(".web-martin-coef-item").each(function() {
						var pos = $(this).val();
						if(pos != "up" && pos != "down") {
							showMessage("User Мартингейл настроен неправильно");
							return false;
						}
						else {
							array["x" + $(this).attr('data-index')] = pos;
						}
					});
					isUserMartingale = array;
					if(Object.keys(array).length < 3 && Object.keys(array).length > 7) {
						showMessage("Укажите правильное количество колен Мартингейла");
						return false;
					}
				}
				var symbols = [];
				$(".web-pair-checked:checked").each(function() {
					symbols.push($(this).val());
				});
				if(stopBalanceHigher > 0)
					settings.stopBalanceHigher = stopBalanceHigher;
				if(stopBalanceLower >= 0)
					settings.stopBalanceLower = stopBalanceLower;

				if($(".web-set-martin").prop("checked")) {
					settings.isUsedMartingale = true;
				}
				else {
					settings.isUsedMartingale = false;
				}
				if($(".web-set-after-martin").prop("checked")) {
					settings.isAfterMartingale = true;
				}
				else {
					settings.isAfterMartingale = false;
				}
				if($(".web-set-timeout").prop("checked")) {
					hours = hours > 9 ? hours : "0" + hours;
					minutes = minutes > 9 ? minutes : "0" + minutes;
					var time = hours + ":" + minutes;
					settings.timeoutValue = time;
					robotTimeout(time);
					$(".web-timeleft-title").html("До завершения:");
				}
				var algorithm = 1;
				if($("input[name=web-algorithm]:checked").length) {
					var va = $("input[name=web-algorithm]:checked").val();
					if(va == 1 || va == 2 || va == 3 || va == 4)
						algorithm = va;
				}
				var timeExp = $(".web-set-time").val();
				settings.timeExp = timeExp;
				settings.algorithm = algorithm;
				settings.martingaleСoefficient = coef;
				settings.numberOfKnees = kness;
				settings.limitedDeal = limited;
				settings.rate = rate;
				settings.minPercent = minPercent;
				settings.symbols = symbols.join(",");
				settings.isUserMartingale = isUserMartingale;

				settings.isRobotStarted = true;
				$(".web-message").slideUp(300);
				$("body, html").animate({scrollTop: 0}, 300);
				$(".web-robot-start").addClass("fade-in");
				settings.socket = new WebSocket("wss://olymptrade.com/ds");
				settings.socket.onopen = function() {
					settings.isSocketConnected = true;
					setTimeout(function() {
						if(!settings.isSocketInitData) {
							$(".web-message").text("Невозможно выполнить соединение, откройте вкладку с платформой Olymptrade").slideDown(300);
							turnOff();
						}
					}, 5000);
				};
				settings.socket.onmessage = function(msg) {
					if(settings.isSocketConnected) {
						var data = JSON.parse(msg.data);
						for(var i = 0; i < data.length; i++) {
							var that = data[i];
							if(that.data_type == "balance" && that.event_name == "balance:change" || that.event_name == "balance_demo:change") {
								settings.balance = that.data["0"].value;
								$(".web-balance").html(settings.balance);
								if(settings.stopBalanceHigher !== false && settings.balance >= settings.stopBalanceHigher)
									turnOff();
								if(settings.stopBalanceLower !== false && settings.balance <= settings.stopBalanceLower)
									turnOff();
								if(that.event_name == "balance_demo:change") {
									$(".web-type").html("демо");
									settings.balanceType = ":demo";
								}
								else {
									$(".web-type").html("реальный");
								}
								settings.isSocketInitData = true;
								if(settings.workedTimeInterval != null)
									clearInterval(settings.workedTimeInterval);
								settings.workedTimeInterval = setInterval(function() {
									settings.workedTime++;
									var lasttime = settings.workedTime;
									if(settings.timeoutValue != "")
										lasttime = getLastTime(settings.timeoutValue);
									var minutes = Math.floor(lasttime / 60),
										seconds = Math.floor(lasttime % 60),
										hours = Math.floor(minutes / 60),
										minutes = Math.floor(minutes % 60),
										hours = Math.floor(hours % 24),
										hours = hours > 9 ? hours : "0" + hours,
										minutes = minutes > 9 ? minutes : "0" + minutes,
										seconds = seconds > 9 ? seconds : "0" + seconds;
										string = hours + ":" + minutes + ":" + seconds;
									$(".web-timeleft").html(string);
								}, 1000);
								checkSignals();
							}
							else if(that.data_type == "pair_schedule") {
								savedWinPercent(that.data["0"].name, that.data["0"].winperc);
							}
							else if(that.data_type == "deal") {
								if(typeof that.error != "undefined" && that.error != null) {
									showMessage(that.error[0].mess);
									$(".web-message").text("Инвестиция не создана, причина: " + that.error[0].mess).slideDown(300);
								}
								else if(that.event_name.search(/^deals(\:?)(.*)\:opening$/i) != -1) {
									for (var j = 0; j < that.data.length; j++) {
										var open = that.data[j];
										settings.opening[open.pair].open = true;
										createItem(open.winperc, open.pair, open.dir, open.amount, 0, "signal", open.currency);
									}
								}
								else if(that.event_name == "deals:closed") {
									for(var j = 0; j < that.data.length; j++) {
										var close = that.data[j],
											status = "zero";
										if(close.status == "win") {
											status = "win";
											delete settings.opening[close.pair];
										}
										else if(close.status == "loose") {
											status = "lose";
											settings.opening[close.pair].open = false;
											settings.opening[close.pair].zero = false;
											if(!settings.isAfterMartingale)
												openDeal(close.pair, close.dir);
										}
										else {
											status = "zero";
											settings.opening[close.pair].open = false;
											settings.opening[close.pair].zero = true;
											if(!settings.isAfterMartingale)
												openDeal(close.pair, close.dir, true);
										}
										if(!Object.keys(settings.opening).length && !settings.isClosedAllDeals)
											turnOff();
										savedWinPercent(close.pair, close.winperc);
										updateItem(close.winperc, close.pair, close.dir, close.amount, close.interim_balance_change, status, close.currency, close.id);
									}
								}
							}
						}
					}
				}
			}
		}
	});
	$(".web-stop").click(function() {
		if(confirm("Хотите прервать работу?")) {
			turnOff();
		}
	});
	$(".web-trigger-pairs").click(function(e) {
		e.preventDefault();
		if(!$(".web-pair a.checked").length) {
			$(".web-pair").each(function() {
				$(this).find("input").attr("checked", "checked");
				$(this).find("a").addClass("checked");
			});
		}
		else {
			$(".web-pair").each(function() {
				$(this).find("input").removeAttr("checked");
				$(this).find("a").removeClass("checked");
			});
		}
	});
	setInterval(function() {
		if(settings.isRobotStarted && settings.isSocketInitData && settings.symbols != "") {
			checkSignals();
		}
	}, 45000);
	function checkSignals() {
		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=web",
			data: {
				"action" : "update",
				"symbols" : settings.symbols,
				"algorithm" : settings.algorithm
			},
			success: function(data) {
				console.log(data);
				if(data != "error_request") {
					var data = JSON.parse(data);
					for(var i = 0; i < data.length; i++) {
						openDeal(data[i].symbol, data[i].position);
					}
				}
			},
			fail: function() {
				showMessage("Проверьте подключение к интернету");
			}
		});
	}
	function savedWinPercent(symbol, percent) {
		settings.percents[symbol] = percent;
		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=web_data",
			data: {
				"action" : "saved",
				"symbol" : symbol,
				"percent" : percent
			}
		});
	}
	function updateItem(percent, symbol, position, rate, profit, status, currency, index) {
		if(typeof currency == "undefined")
			var currency = "";
		if(typeof index == "undefined")
			var index = "";
		currency = currency.toUpperCase();
		var gNowDate = getNowDate();
		var drawData = {
			"profit": "",
			"symbol": "",
			"positionName": "",
			"rate": "",
			"date": gNowDate,
			"percent" : percent
		};
		profit = Math.abs(Number(profit));
		profit = Number(profit).toFixed(1);
		if(status == "win")
			drawData.profit = "+" + profit + currency;
		else if(status == "lose")
			drawData.profit = "-" + profit + currency;
		else if(status == "zero")
			drawData.profit = "Возврат";
		drawData.symbol = symbol == "XAUUSD" ? "GOLD" : symbol;
		drawData.symbol = drawData.symbol.toUpperCase();
		drawData.rate = rate + currency;
		drawData.positionName = position == "up" ? "Вверх" : "Вниз";
		var $template = $(".web-item-investition[data-symbol="+drawData.symbol+"]:first");
		$template.find(".web-item-date").html($template.find(".web-item-date").text() + "<br>" + drawData.date);
		$template.find(".web-item-rate").text(drawData.rate);
		$template.find(".web-item-status").text(drawData.profit).addClass("web-" + status);
		if(!$(".web-history-item").length)
			$(".web-history-items").html("");
		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=web_data&time=" + Date.now(),
			data: {
				"action" : "update",
				"symbol" : symbol,
				"position" : position,
				"rate" : rate,
				"profit" : profit,
				"status" : status,
				"currency" : currency,
				"index" : "",
				"date" : gNowDate,
				"percent" : percent
			}
		});
	}
	function createItem(percent, symbol, position, rate, profit, status, currency, index) {
		if(typeof currency == "undefined")
			var currency = "";
		if(typeof index == "undefined")
			var index = "";
		$(".web-table-info .fa").removeClass("opacity-zero");
		currency = currency.toUpperCase();
		var gNowDate = getNowDate();
		var drawData = {
			"profit": "",
			"symbol": "",
			"positionName": "",
			"rate": "",
			"date": gNowDate,
			"percent" : percent
		};
		profit = Math.abs(Number(profit));
		profit = Number(profit).toFixed(1);
		if(status == "win")
			drawData.profit = "+" + profit + currency;
		else if(status == "lose")
			drawData.profit = "-" + profit + currency;
		else if(status == "zero")
			drawData.profit = "Возврат";
		else 
			drawData.profit = "Инвестиция";
		drawData.symbol = symbol == "XAUUSD" ? "GOLD" : symbol;
		drawData.symbol = drawData.symbol.toUpperCase();
		drawData.rate = rate + currency;
		drawData.positionName = position == "up" ? "Вверх" : "Вниз";
		var template = "";
		if(status != "signal")
			template = $("#web-template-item").html();
		else
			template = $("#web-template-item-process").html();
		var $template = $(template);
		var percentName = "default";
		$template.addClass("web-item-investition").attr("data-symbol", drawData.symbol);
		if(percent > 79)
			percentName = "power";
		$template.find(".web-item-percent").text(percent + "%").addClass(percentName);
		$template.find(".web-item-date").text(drawData.date);
		$template.find(".web-item-img").attr("src", $template.find(".web-item-img").attr("src").replace("{symbol}", drawData.symbol));
		$template.find(".web-item-symbol").text(drawData.symbol);
		$template.find(".web-item-position").addClass("fa-arrow-" + position);
		$template.find(".web-item-position-name").text(drawData.positionName);
		$template.find(".web-item-rate").text(drawData.rate);
		$template.find(".web-item-status").text(drawData.profit).addClass("web-" + status);
		if(!$(".web-history-item").length)
			$(".web-history-items").html("");
		var uId = generate();
		if($template.find(".web-process").length) {
			$template.find(".web-process").attr("id", "web-tick-" + uId);
		}
		$(".web-history-items").prepend($template);
		$(".web-table-info .fa").addClass("opacity-zero");
		initTimer(uId);

		$.ajax({
			method: "POST",
			url: "../index.php?page=ajax&ajax-handle=web_data&time=" + Date.now(),
			data: {
				"action" : "create",
				"symbol" : symbol,
				"position" : position,
				"rate" : rate,
				"profit" : profit,
				"status" : status,
				"currency" : currency,
				"index" : index,
				"date" : gNowDate,
				"percent" : percent
			}
		});
	}
	function upload() {
		if(isUploaded) {
			isUploaded = false;
			var num = $(".web-history-item").length;
			if(num >= 15) {
				$(".web-loader").show();
				$.ajax({
					method: "POST",
					url: "../index.php?page=ajax&ajax-handle=web_data",
					data: {
						"action" : "upload",
						"num" : num
					},
					success: function(data) {
						if(data != "") {
							$(".web-history-items").append(data);
							isUploaded = true;
						}
						$(".web-loader").hide();
					},
					fail: function() {
						isUploaded = true;
						$(".web-loader").hide();
						showMessage("Проверьте подключение к интернету");
					}
				});
			}
		}
	}
	$("body").on("click", ".web-lasttime-close", function() {
		if($(".web-lasttime-title").is(":visible")) {
			$(".web-lasttime-title").slideUp(300);
		}
		else {
			$(".web-lasttime-title").slideDown(300);
		}
	});
	$(".web-clear").click(function() {
		if(!settings.isRobotStarted) {
			if(confirm("Вы хотите очистить историю торговли?")) {
				if(isCleared) {
					var btn = $(this),
						btnVal = $(btn).html();
					isCleared = false;
					$(btn).html("<i class='fa fa-spin fa-spinner'></i> " + btnVal);
					$.ajax({
						method: "POST",
						url: "../index.php?page=ajax&ajax-handle=web_data",
						data: {
							"action" : "clear"
						},
						success: function(data) {
							isCleared = true;
							$(btn).html(btnVal);
							if(data != "") {
								$(".web-history-items").html(data);
							}
						},
						fail: function() {
							isCleared = true;
							$(btn).html(btnVal);
							$(".web-loader").hide();
							showMessage("Проверьте подключение к интернету");
						}
					});
				}
			}
		}
	});
	$(window).scroll(function() {
		if($(".web-history-item").length) {
			var position = $(".web-history-item:last").offset().top;
			if($(window).height() + $(document).scrollTop() >= position) {
				upload();
			}
		}
	});
	function getLastTime(time) {
		var now = new Date(),
		year = now.getFullYear(),
		month = now.getMonth() + 1,
		day = now.getDate(),
		month = month > 9 ? month : "0" + month,
		day = day > 9 ? day : "0" + day,
		string = year + "-" + month + "-" + day + " " + time + ":00",
		newDate = Date.parse(string);
		if(newDate < Date.now())
			newDate = newDate + (1000 * 60 * 60 * 24);
		return Math.round((newDate - Date.now()) / 1000);
	}
	function initTimer(id) {
		$("#web-tick-"+id).find(".web-process-loader").animate({"width" : "0%"}, 60 * settings.timeExp * 1000, function() {
			$("#web-tick-"+id).remove();
		});
	}
	setInterval(changeTime, 60000);
  function changeTime() {
      $.ajax({
          method: "POST",
          url: "../index.php?page=ajax&ajax-handle=web_data",
          data: {
              action: "change-time"
          },
          success: function(data) {
              if(data != 'error') {
                  data = JSON.parse(data);
                  if(data.answer == 'over') {
                      $("#content").html(data.text);
                      $(".timeleft-vip").text("0 дней 00:00");
                  }
                  else {
                      if(data.answer == 'normal') {
                          $(".timeleft-vip").text(data.text);
                      }
                      else if(data.answer == "demo") {
                      	if(settings.balanceType != ":demo") {
                      		$(".web-message").text("Для тестового периода доступна только торговля на Demo счете").slideDown(300);
                      		turnOff();
                      	}
                      	if(data.text == "0")
                      		$(".web-lasttime").hide();
                      	else
                      		$(".web-lasttime").show();
                      	$(".web-lasttime h1").text(data.text + "мин.");
                      }
                  }
              }
          }
      });
  }
});
function generate() {
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	for( var i=0; i < 9; i++ )
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	return text;
}
function getNowDate() {
	var date = new Date(),
		year = date.getFullYear(),
		month = date.getMonth() + 1,
		day = date.getDate(),
		hours = date.getHours(),
		minutes = date.getMinutes(),
		seconds = date.getSeconds();
	month = month < 10 ? "0" + month : month;
	day = day < 10 ? "0" + day : day;
	hours = hours < 10 ? "0" + hours : hours;
	minutes = minutes < 10 ? "0" + minutes : minutes;
	seconds = seconds < 10 ? "0" + seconds : seconds;
	date = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
	return date;
}