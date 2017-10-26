<div class="web-lasttime">
	<div class="web-lasttime-close"><i class="fa fa-close"></i></div>
	<div class="web-lasttime-title">До завершения пройбной версии осталось:</div>
	<h1>23 мин.</h1>
</div>
<div class="row">
	<div class="web-info col-md-12">
		<h1>Как настроить и запустить робота?</h1>
		<ol>
			<li>Параллельно откройте платформу <a target="_blank" href="https://affiliate.olymptrade.com/tds/53251/">Olymptrade</a></li>
			<li>На платформе выберете тип счета (демо/реальный)</li>
			<li>Настройте робота</li>
			<li>Нажмите "Запустить"</li>
			<li>Не закрывайте вкладку с роботом и платформой Olymptrade</li>
			<li>Остались вопросы? - <a target="_blank" href="%URI%/faq-elly/">перейдите сюда</a></li>
		</ol>
		<button class="web-clear">Очистить историю</button>
		<a href="https://trust-signals.com/binomo/"><button style="font-size: 20px;
    font-weight: bold;
    color: #5d5d5d;
    padding: 10px 20px;
    border-radius: 4px;
    background-color: #FFDD47;
    border: none;
    position: absolute;
    right: 70px;
    top: 100px;
    transition: .3s;">Сменить на Binomo</button></a>
	</div>
	<div class="col-md-12 web-message"></div>
	<div class="web-table">
		<div class="web-row">
			<div class="web-settings web-cell">
				<div class="web-robot-start">
					<div class="web-start-info">
						<div class="web-title web-status"><i class="fa fa-circle"></i> Робот запущен</div>
						<div class="web-title">Баланс:</div>
						<div class="web-value web-balance"><i class="fa fa-spin fa-spinner"></i></div>
						<div class="web-title">Тип счета:</div>
						<div class="web-value web-type"><i class="fa fa-spin fa-spinner"></i></div>
						<div class="web-title web-timeleft-title">Время работы:</div>
						<div class="web-value web-timeleft">00:00:00</div>
					</div>
					<button class="web-stop"><i class="fa fa-stop-circle"></i> Остановить</button>
				</div>
				<div class="web-settings-box">
					<div class="panel panel-default">
						<div class="panel-body">
							<span class="fa fa-cogs"></span> Настройка робота
						</div>
						<div class="panel-footer">
							<div class="form-group">
								<label>Валютные пары (<a class="web-trigger-pairs" href="#">Выбрать все</a>)</label>
								<div class="web-pairs">
									%pairs_list%
								</div>
							</div>
							<div class="form-group">
								<label>Время</label>
								<div class="width-100-percent input-group">
									<select class="width-100-percent web-set-time form-control">
										<option value="1">1 минута</option>
										<option value="5">5 минут</option>
										<option value="15">15 минут</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label>Ставка</label>
								<div class="input-group">
									<span class="input-group-addon">
										<i class='fa fa-dollar'></i>
										<i class='fa fa-euro'></i>
										<i class='fa fa-rub'></i>
									</span>
									<input type="text" class="web-set-rate form-control" value="1">
									<span class="input-group-addon">.00</span>
								</div>
							</div>
							<div class="form-group">
								<label>Минимальная прибыль по паре</label>
								<div class="input-group">
									<input type="text" class="web-set-percent form-control" value="70">
									<span class="input-group-addon">%</span>
								</div>
							</div>
						</div>
						<div class="panel-more panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<i class="fa fa-stack-overflow"></i> Расширенная настройка
								</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="form-border form-group">
										<input class="web-set-martin" type="checkbox" checked data-label="Торговля с Мартингейлом "  name=""> <span data-toggle="tooltip" data-placement="right" title="Tooltip on right">(?)</span>
										
									</div>
									<div class="web-set-martin-box">
										<div class="form-border form-group">
											<input class="web-set-after-martin" type="checkbox" data-label="Мартин после нового сигнала" name="">
										</div>
										<div class="form-border form-group">
											<input class="web-set-user-martin" type="checkbox" data-label="User Мартингейл" name="">
										</div>
										<div class="row web-user-list">
											<div class="col-md-4">
												<div class="form-group">
													<label>Колено <span class="number">2</span></label>
													<select data-index="1" class="web-martin-coef-item form-control">
														<option value="up">Вверх</option>
														<option value="down">Вниз</option>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Колено <span class="number">3</span></label>
													<select data-index="2" class="web-martin-coef-item form-control">
														<option value="up">Вверх</option>
														<option value="down">Вниз</option>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Колено <span class="number">4</span></label>
													<select data-index="3" class="web-martin-coef-item form-control">
														<option value="up">Вверх</option>
														<option value="down">Вниз</option>
													</select>
												</div>
											</div>
										</div>
										<div class="web-default-martin form-group">
											<label>Коэффициент Мартингейла</label>
											<input type="text" placeholder="от 2.3 до 5.0" class="form-control web-set-coef">
										</div>
										<div class="form-group">
											<label>Количество колен Мартингейла</label>
											<input type="text" placeholder="от 3 до 30" class="form-control web-set-kness">
										</div>
									</div>
									<div class="form-group">
										<label>Количество одновременных сделок</label>
										<input type="text" placeholder="от 1 до 3" class="web-set-limited form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="panel-more panel panel-default">
							<div class="panel-heading" role="tab" id="headingAlg">
								<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAlg" aria-expanded="true" aria-controls="collapseOne">
								<i class="fa fa-signal"></i> Тип сигналов
								</a>
								</h4>
							</div>
							<div id="collapseAlg" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<div class="form-border form-group">
										<label><input type="radio" value="1" checked name="web-algorithm"> Rotation elly signal</label>
									</div>
									<div class="form-border form-group">
										<label><input type="radio" value="2" name="web-algorithm"> Трендовые сигналы</label>
									</div>
									<div class="form-border form-group">
										<label><input type="radio" value="3" name="web-algorithm"> Инверсионные сигналы</label>
									</div>
									<div class="form-border form-group">
										<label><input type="radio" value="4" name="web-algorithm"> Mix Double signal</label>
									</div>
								</div>
							</div>
						</div>
						<div class="panel-more panel panel-default">
							<div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
								<i class="fa fa-stop-circle-o"></i> Ограничения
								</a>
								</h4>
							</div>
							<div id="collapseTwo" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="headingTwo">
								<div class="panel-body">
									<div class="form-group">
										<input class="web-set-timeout" type="checkbox" data-label="Остановить в указанное время" name="">
										<div class="web-set-timeout-wrap">
											<table>
												<tr>
													<td width="45%">
														<input type="text" class="web-set-hours text-center form-control" placeholder="12">
													</td>
													<td align="center" width="10%">:</td>
													<td width="45%">
														<input type="text" class="web-set-minutes text-center form-control" placeholder="54">
													</td>
												</tr>
											</table>
										</div>
									</div>
									<div class="form-group">
										<label>Остановить когда баланс выше:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class='fa fa-dollar'></i>
												<i class='fa fa-euro'></i>
												<i class='fa fa-rub'></i>
											</span>
											<input type="text" class="web-set-higher form-control" value="">
											<span class="input-group-addon">.00</span>
										</div>
									</div>
									<div class="form-group">
										<label>Остановить когда баланс ниже:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<i class='fa fa-dollar'></i>
												<i class='fa fa-euro'></i>
												<i class='fa fa-rub'></i>
											</span>
											<input type="text" class="web-set-lower form-control" value="">
											<span class="input-group-addon">.00</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group web-launch-group">
							<button class="web-launch"><i class="fa fa-rocket"></i> Запустить</button>
						</div>
					</div>
				</div>
			</div>
			<div class="web-content web-cell">
				<table class="table">
					<tr class="web-table-info">
						<th>Дата <i class="opacity-zero fa fa-spin fa-spinner"></i></th>
						<th class="two">Валюта <i class="opacity-zero fa fa-spin fa-spinner"></i></th>
						<th class="three">Направление <i class="opacity-zero fa fa-spin fa-spinner"></i></th>
						<th class="text-center">Ставка <i class="opacity-zero fa fa-spin fa-spinner"></i></th>
						<th>Результат <i class="opacity-zero fa fa-spin fa-spinner"></i></th>
					</tr>
					<tbody class="web-history-items">
						%history%
					</tbody>
				</table>
				<div class="web-loader">
					<span class="fa fa-spin fa-spinner"></span>
				</div>
			</div>
		</div>
	</div>
</div>
<script id="web-template-item" type="template/web">
	%item%
</script>
<script id="web-template-item-process" type="template/web">
	%item_with_process%
</script>
<script id="web-template-user" type="template/web">
	<div class="col-md-4">
		<div class="form-group">
			<label>Колено <span class="number"></span></label>
			<select data-index="" class="web-martin-coef-item form-control">
				<option value="up">Вверх</option>
				<option value="down">Вниз</option>
			</select>
		</div>
	</div>
</script>