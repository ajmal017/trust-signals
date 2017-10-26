<!-- AUTH -->
<div class="modal fade" id="auth-modal" tabindex="-1" role="dialog" aria-labelledby="auth-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="auth-label">Авторизация</h4>
            </div>
            <div class="modal-body">
                <!--<p class="text-center">
                    <a href="%vk_url%"><img width="16" height="16" src="%root%/img/soc/vk.png" alt=""/> VK</a>
                    <a href="%ok_url%"><img width="16" height="16" src="%root%/img/soc/ok.png" alt=""/> OK</a>
                    <a href="%ya_url%"><img width="16" height="16" src="%root%/img/soc/ya.png" alt=""/> Yandex</a>
                </p>-->
                <div class="form-group">
                    <label for="disabled-email"><span id="auth-email-desc">E-mail</span></label>
                    <input type="text" class="form-control" id="auth-email" placeholder="Ваш E-mail адрес">
                </div>
                <div class="form-group">
                    <label for="disabled-email"><span id="auth-password-desc">Пароль</span></label>
                    <input type="password" class="form-control" id="auth-password" placeholder="Ваш пароль">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary auth-btn">Войти</button>
                    <button class="btn btn-warning recovery-btn">Забыл пароль?</button>
                </div>
                <div class="wrap-recovery">
                    <div class="form-group">
                        <label for="disabled-email"><span id="auth-email2-desc">E-mail</span></label>
                        <input type="text" class="form-control" id="auth-email2" placeholder="Ваш E-mail адрес">
                    </div>
                    <input type="hidden" class="form-control" id="auth-word" value="">
                    <!--<div class="form-group">
                        <label for="disabled-email"><span id="auth-word-desc">Секретное слово</span></label>
                        <input type="text" class="form-control" id="auth-word" value="" placeholder="Ваше секретное слово">
                    </div>-->
                    <div class="form-group">
                        <button class="btn btn-success recovery-password">Восстановить пароль</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- REGISTER -->
<div class="modal fade" id="reg-modal" tabindex="-1" role="dialog" aria-labelledby="reg-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reg-label">Регистрация</h4>
            </div>
            <div class="modal-body">
                <!--<p class="text-center">
                    <a href="%vk_url%"><img width="16" height="16" src="%root%/img/soc/vk.png" alt=""/> VK</a>
                    <a href="%ok_url%"><img width="16" height="16" src="%root%/img/soc/ok.png" alt=""/> OK</a>
                    <a href="%ya_url%"><img width="16" height="16" src="%root%/img/soc/ya.png" alt=""/> Yandex</a>
                </p>-->
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
                    <input type="checkbox" id="reg-rules" data-label="Я соглашаюсь <a class='to-bottom-rules' data-dismiss='modal' aria-label='Close' href='#'>с правилами сервиса</a>">
                </div>
                <div class="form-group">
                    <button class="btn btn-success reg-btn">Регистрация</button> <a href="#" data-toggle="modal"  data-target="#auth-modal" aria-hidden="true" data-dismiss="modal" aria-label="Close"> Уже есть аккаунт(?)</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- RULES -->
<div class="modal fade" id="rules-modal" tabindex="-1" role="dialog" aria-labelledby="rules-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Правила и ответственность сторон.</h4>
            </div>
            <div class="modal-body">
                <div class="main-box-body clearfix">

                    <!--content-->
                    <div class="row" id="common_page">
                        <div class="col-sm-12" style="font-size: 13px">
     <p>1 | Мы не имеем никакого отношения к брокерам, не предоставляем и никогда не предоставляли свои торговые сигналы брокерам, в частности IQ option!</p>

     <p>2 | Любое использование, как любой из частей, так и всего программного комплекса приема торговых сигналов, тестирования торговых стратегий "OPTION SIGNAL" и программных продуктов на его базе (далее «Сервис»), допустимо только в полном принятии настоящих Правил оказания услуг (далее Правила).</p>

     <p>3 | Используя Сервис, в том числе и веб-приложение на его базе, Вы осознаете и подтверждаете, что Вы: во-первых - прочитали и поняли содержание настоящих Правил; во-вторых - согласны соблюдать настоящие Правила; в-третьих - достигли установленного законом возраста для заключения соглашений аналогичных этому.</p>

     <p>4 | Поставляемые сервисом торговые сигналы являются нашим общерыночным комментарием и мы не несём ответственность за потерю вашего депозита, так как торговля бинарными опционами сопряжена с высоким риском. Мы не гарантируем 100% результат.</p>

     <p>5 | Не существует метода, позволяющего гарантировать прибыль от операций на финансовых рынках. Мы не обязаны поставлять торговые сигналы, связанные с котировками на каком-то конкретном рынке.</p>

     <p>6 | Пользователь осознает риски, связанные с использованием интернета и мобильной связи, в том числе аппаратного и программного обеспечения, каналов связи.</p>

     <p>7 | Пользователь может использовать Сервис только для целей, связанных с его нормальным функционированием, и только до тех пор - пока находится в рамках настоящего Соглашения.</p>

     <p>8 | В аспекте использования Сервиса, пользователь соглашается соблюдать все местные, региональные, государственные и международные законы и договоренности, и обязуется - не нарушать, не способствовать нарушению третьей стороной, не ущемлять любые права (имущественные и неимущественные) других лиц, нашей политики и механизмов обеспечения безопасности Сервиса.</p>

     <p>9 | Вы признаете, что Сервис и его содержимое - торговые знаки, знаки обслуживания и логотипы, содержащиеся в Сервисе, защищены авторскими правами, торговыми знаками, патентами и другими правами собственности, как по отношению к отдельным объектам, так и к групповой работе ,и комплекса в целом.В соответствии с законодательством и международными конвенциями.</p>

     <p>10 | Информация и Сервис предоставляются на условиях "как есть" и "как доступен". Мы отказываемся от всех гарантий любого рода, явных или подразумеваемых, включая, помимо прочего, гарантии пригодности для конкретных целей и отсутствия нарушения прав.</p>

     <p>11 | Мы не предоставляем гарантии, что Сервис или информация, размещенная посредством Сервиса, будут соответствовать Вашим требованиям или будут исчерпывающими, своевременными, безопасными, точными, корректными или будут доступными.</p>

	 <p>12 | Ни при каких обстоятельствах мы не несем ответственности за непрямые, случайные, специальные, штрафные или косвенные убытки, возникшие: в результате использования или невозможности использования любой части или целиком Сервиса; в результате неточностей или ошибок в информационном содержимом.</p>
	
	 <p>13 | Сервис не возвращает непотраченые средства, оставшиеся в качестве времени на балансе в личном кабинете у пользователя, так как мы работаем с партнёрами!</p>
	
	   <p> 14 | Пользователь оплачивает не за торговые сигналы, а за использование ресурсов нашего Сервера.</p>
	
	 <p>15 | Общее предупреждение о риске: "Торговля бинарными опционами является высоко-рискованной и может привести к частичной или полной потере всех средств на Вашем счете!" </p>
          Перед принятием решения о начале торговли, рекомендуем ознакомиться с правилами и условиями торговли. Все решения принимаются трейдерами самостоятельно.Сервис не несет за них ответственности.</p>
	 
	 <p>16 | Адмистрация оставляет за сабой право редактировать и дополнять настоящее Соглашение - правило.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>