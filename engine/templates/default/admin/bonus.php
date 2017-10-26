<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Бонусный модуль</h3>
<input type="checkbox" class="checkbox-styler" %checked% id="bonus-module" data-label="Включить бонусный модуль">
<h3 class="text-center panel-title"><span class="glyphicon glyphicon-record"></span> Добавить бонусный ключ</h3>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label for="exampleInputEmail1">Ключ ( <a class="get-key" href="#">Сгенерировать</a>)</label>
			<input type="text" class="form-control" id="bonus-key" placeholder="AHG5@nHGQ2">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="exampleInputEmail1">Процент</label>
			<input type="text" class="form-control" id="bonus-percent" placeholder="Например, 15">
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="exampleInputEmail1">Добавить</label>
			<div><button class="bonus-add btn btn-primary">Добавить ключ</button></div>
		</div>
	</div>
</div>
<div class="bonuses-list">
	%bonuses%
</div>