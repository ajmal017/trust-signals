<?php header("Access-Control-Allow-Origin: *"); ?>
<meta http-equiv="Content-Security-Policy" content="default-src 'self' data: gap: cdvfile: https://ssl.gstatic.com; style-src 'self' 'unsafe-inline'; media-src *">
<meta http-equiv="Cache-Control" content="no-cache"><div class="auth-wrap">
	<div class="auth-bg">
		<div class="auth-logo animated slideInUp">
			<div class="auth-type-char auth-char-blue">Option-<span class="auth-type-char auth-char-pink">Signal</span></div>
		</div>
		<div class="auth-box">
			<div class="slideInRight animated auth-wrap-line">
				<input type="text" value="E-mail" class="login">
				<div class="auth-icon"><i class="fa fa-envelope-o"></i></div>
			</div>
			<div class=" slideInLeft animated auth-wrap-line auth-wrap-line-pass">
				<input type="password" value="Пароль" class="password">
				<div class="auth-icon"><i class="fa fa-key"></i></div>
			</div>
			<button class="auth zoomInUp animated">Войти</button>
			<div class="auth-navigation">
				<div href="#" class="slideInUp animated">
					<span onclick="intel.xdk.device.launchExternal('http://trust-signals.com/reg/');">Регистрация</span> | <span onclick="intel.xdk.device.launchExternal('http://trust-signals.com/remember/');">Забыл пароль</span>
				</div>
			</div>
		</div>
	</div>
</div>