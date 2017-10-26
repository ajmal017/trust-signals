//BlackSwan Studio 2015 / www.bslp.ru
/*============================ TYPED
/*=========================================================*/

/*=========================================================*/
$(document).ready(function(){
	/* ============================ Calculation ==============*/
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
	/* ============================ MENU =====================*/
	var $menu = $("#menu");
	$(window).scroll(function(){
		if ($(this).scrollTop() > 210 && $menu.hasClass("default")){$menu.fadeOut('fast',function(){$(this).removeClass("default") .addClass("fixed transbg") .fadeIn('fast');});} 
		else if($(this).scrollTop() <= 210 && $menu.hasClass("fixed")){$menu.fadeOut('fast',function(){$(this).removeClass("fixed transbg") .addClass("default") .fadeIn('fast');});}
	});
	$menu.hover(function(){if( $(this).hasClass('fixed') ){$(this).removeClass('transbg');}}, function(){if($(this).hasClass('fixed') ){$(this).addClass('transbg');}});
	/* ============================ MOUSE PARALLAX ===========*/
	/* ============================ HEAD SLIDE ===============*/
});
/*============================ SLIDER
/*=========================================================*/
$('#BSslider-head').bxSlider({
	auto: false,
	autoControls: false,
	pause: 3000,
	slideMargin: 0,
	speed: 500,
	pagerCustom: '#bx-pager',
	autoStart: false,
	autoHover: true
});
$('#BSslider').bxSlider({
	auto: true,
	autoControls: false,
	pause: 9000,
	slideMargin: 0
});

/*
$('#BSslider-vert').bxSlider({
	auto: false,
	autoControls: false,
	pause: 3000,
	slideMargin: 0,
	speed: 500,
	autoStart: false,
	autoHover: true
});*/

var slider = $('#BSslider-vert'); // селектор слайдера
var pagerItem = $('#BSslider-pager li'); // селектор пункта пагинатора
var active = 'active'; // класс активного пункта пагинатора

if ( slider.length ) {
	var prev = false;
	function pager() {
		pagerItem.filter('.' + active).each(function() {
			var el = $(this);
			if (prev) {
				if ( el.is(':first-child') ) {
					el.removeClass(active);
					pagerItem.filter(':last').addClass(active);
				} else el.removeClass(active).prev().addClass(active);
			} else {
				if ( el.is(':last-child') ) {
					el.removeClass(active);
					pagerItem.filter(':first').addClass(active);
				} else el.removeClass(active).next().addClass(active);
			}
		})
	}
	slider.bxSlider({
		// опции плагина
		mode: 'fade',
		controls: false,
		pager: false,
		auto: false,
		autoStart: false,
		autoHover: true,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 500,
		useCSS: false, // отключаем CSS-анимацию
		pause: 22000,
		speed: 0,
		onSlidePrev: function() { prev = true;  pager(); },
		onSlideNext: function() { prev = false; pager(); }
		// конец опций
	});
	pagerItem.click(function() {
		slider.stopAuto();
		var index = pagerItem.index($(this));
		slider.finish().goToSlide(index);
		pagerItem.removeClass(active);
		$(this).addClass(active);
	}).mouseleave(function() {
		slider.startAuto();
	});
	pagerItem.filter(':first').addClass(active);
}
// end slider


/*============================ TABS
/*=========================================================*/