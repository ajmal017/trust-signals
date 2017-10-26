/*
* Generated: 20.04.2015 15:50
* Copyright (c) 2014. BlackSwan Studio.
* All rights reserved.
*/

function rand( min, max ) {	// Generate a random integer
	// 
	// +   original by: Leslie Hoare

	if( max ) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	} else {
		return Math.floor(Math.random() * (min + 1));
	}
}


function UpdatePayMonth()
	{
		var p = 1.2; //1 + 80 процентов по формуле a*(1+0.8)^n
		var a = $("#avto_price").val(); //начальная сумма сделки
		var ash = a*1;
		var n = 53; //Кол-во успешных сделок в день
		var d = $("#srok_kredita").val(); //Кол-во торговых дней
		var g = n * d; //Кол-во сделок за весь период
		var stepen = Math.pow(p, g);
		var b = 160;
		var s1 = a * n * d; // Общая прибыль при начальной сумме до 200$ включительно

		$("#pay_month").val(s1.toFixed(0));
		document.getElementById('pay_month').innerHTML = '<i>$</i>&nbsp;'+s1.toFixed(0).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
		document.getElementById('two_stolb').style.height=(s1/100).toFixed(0)+'px';
		document.getElementById("two_stolb_znach").innerHTML = s1.toFixed(0).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
		if(typeof(Storage)!=="undefined"){sessionStorage.setItem('klv', g);sessionStorage.setItem('number', s1.toFixed(0));sessionStorage.setItem('depo', a);}
		else {alert('Внимание! Старый браузер! Ваш браузер не поддерживает новые технологии.');}

		
		if (n == 1){var sdelok = "сделка";}
		if (n >= 2 && n <= 4){var sdelok = "сделки".toLowerCase();}
		if (n >= 5 && n <= 10){var sdelok = "сделок";}
		document.getElementById("sdelok").innerHTML = sdelok;
		
		if (d == 1 || d == 21){var dnei = "день";}
		if (d >= 2 && d <= 4 || d >= 22 && d <= 24){var dnei = "дня".toLowerCase();}
		if (d >= 5 && d < 21 || d > 24 && d <= 30){var dnei = "дней";}
		document.getElementById("dnei").innerHTML = dnei;
		document.getElementById("klvday").innerHTML = d+"&nbsp;"+dnei;
		
		document.getElementById('one_stolb1').style.height=(a/5).toFixed(0)+'px';
		document.getElementById('one_stolb2').style.height=(a/5).toFixed(0)+'px';
		
		document.getElementById("one_stolb_znach").innerHTML = a;
		//document.getElementById('pay_month').style='filter:blur('+($("#srok_kredita").val()/6).toFixed(0)+'px)';
	}
function CheckValid(value, type)
	{
		var c = value.length;
		var new_value = "0";
		for (var i = 0; i < c; i++){if (value[i].match(/[0-9]/)) {new_value += value[i];}}
		var ready_value = Number(new_value);
		switch (type)
			{
				case "0": if (ready_value > 100) { return 100; } else { return ready_value; } break;
				case "1": if (ready_value > 100) { return 100; } else { return ready_value; } break;
				case "2": if (ready_value > 30) { return 30; } else { return ready_value; } break;
			}
	}
/*
$(document).ready(function(){
		
		$("#div_price").slider({
			range: "min",
			animate: true,
			min: 1,
			max: 100,
			value: 20,
			step: 1,
			slide: function( event, ui ) {$("#avto_price").val(ui.value); UpdatePayMonth();}
		});
		$("#div_vznos").slider({
			range: "min",
			animate: true,
			min: 1,
			max: 10,
			value: 1,
			step: 1,
			slide: function( event, ui ) {$("#first_vznos").val(ui.value); UpdatePayMonth();}
		});
		$("#div_month").slider({
			range: "min",
			animate: true,
			min: 1,
			max: 30,
			value: 1,
			step: 1,
			slide: function( event, ui ) {$("#srok_kredita").val(ui.value); UpdatePayMonth();}
		});
		
		$("#avto_price").val($("#div_price").slider("value"));
		$("#first_vznos").val($("#div_vznos").slider("value"));
		$("#srok_kredita").val($("#div_month").slider("value"));
		$("#avto_price").change(function(){
				$("#div_price").slider("value", CheckValid($("#avto_price").val(), "0"));
				$("#avto_price").val(CheckValid($("#avto_price").val(), "0"));
				UpdatePayMonth();
			});
		$("#first_vznos").change(function() {
				$("#div_vznos").slider("value", CheckValid($("#first_vznos").val(), "1"));
				$("#first_vznos").val(CheckValid($("#first_vznos").val(), "1"));
				UpdatePayMonth();
			});
		$("#srok_kredita").change(function() {
				$("#div_month").slider("value", CheckValid($("#srok_kredita").val(), "2"));
				$("#srok_kredita").val(CheckValid($("#srok_kredita").val(), "2"));
				UpdatePayMonth();
			});
	});*/