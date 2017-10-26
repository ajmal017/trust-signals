<!DOCTYPE html>
<html>
<head>
	<title>%title%</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="%root%/img/favicon-home.png">
	<link href="%root%/css/bootstrap.min.css" rel="stylesheet">
	<link href="%root%/css/checkbox.css" rel="stylesheet">
	<link href="%root%/css/reg.css" rel="stylesheet">
</head>
<body>
	<div class="header">РЕГИСТРАЦИЯ</div>
	<div id="reg">
		<div class="form-group">
            <label for="disabled-email"><span id="auth-password-desc">Имя</span></label>
            <input type="text" class="form-control" id="reg-name" placeholder="Ваше имя">
        </div>
        <div class="form-group">
            <label for="disabled-email"><span id="auth-password-desc">Email</span></label>
            <input type="text" class="form-control" id="reg-email" placeholder="Ваш E-mail адрес">
        </div>
        <div class="form-group">
            <label for="disabled-email"><span id="auth-password-desc">Пароль</span></label>
            <input type="password" class="form-control" id="reg-password" placeholder="Ваш пароль">
        </div>
        <div class="form-group">
            <label for="disabled-email"><span id="auth-password-desc">Подтвердите пароль</span></label>
            <input type="password" class="form-control" id="reg-password2" placeholder="Подтвердите пароль">
        </div>
        <div class="form-group">
            <label for="disabled-email"><span id="auth-password-desc">Секретное слово <span data-toggle="tooltip" data-placement="top" title="Придумайте секретное слово. Оно необходимо при попытке восстановления пароля" class="glyphicon glyphicon-question-sign"></span></span></label>
            <input type="text" class="form-control" id="reg-word" placeholder="Секретное слово">
        </div>
        <div class="form-group">
            <label for="disabled-email">Пол: </label>
            <select id="reg-sex">
                <option></option>
                <option value="1">Мужской</option>
                <option value="0">Женский</option>
            </select>
        </div>
        <div class="form-group">
            <input type="checkbox" id="reg-rules" data-label="Я соглашаюсь с правилами</a>">
        </div>
        <div class="form-group">
            <button class="btn btn-success reg-btn">Регистрация</button></a>
        </div>
	</div>
	<script src="%root%/js/jquery.min.js"></script>
	<script src="%root%/js/bootstrap.min.js"></script>
	<script src="%root%/js/jquery-ui.js"></script>
	<script src="%root%/js/wow.min.js"></script>
	<script src="%root%/js/checkbox.min.js"></script>
	<script src="%root%/js/home_new.js"></script>
</body>
</html>