<div>
    <ul class="nav nav nav-pills" role="tablist">
        <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-briefcase"></span> Стратегии для БК</a></li>
        <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-star-empty"></span> Стратегии для VIP</a></li>
        <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-facetime-video"></span> Стратегии от пользователей</a></li>
    </ul>
    <style>
        .hd {
            position: absolute;
            margin-top: -20px;
            margin-left: -15px;
            background-color: rgba(76, 14, 14, 0.46);
            width: 100%;
            height: 100%;
            opacity: 0;
        }

        .hd:hover {
            opacity: 1;
        }
    </style>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1">
        %strategies%
	</div>
    <div role="tabpanel" class="tab-pane" id="tab2">%strategies_vip%</div>
    <div role="tabpanel" class="tab-pane" id="tab3">
	<div class="row">
	<div class="col-md-12" style="margin-top: 10px;
    background-color: #F7F7F7;
    padding: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);"><div class="col-md-6">
	 Внимание! Вы можете добавить своё обучающее видео.</div>
	 <div class="col-md-6 text-right">
	<!-- Split button -->
<div class="btn-group">
 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-toggle="tooltip" title="Сортировка уроков">
     <span class="caret"></span> <span id="sort-title">Сортировка</span>
     <span class="sr-only">Меню с переключением</span>
 </button>
  <ul class="dropdown-menu" role="menu">
    <li><a data-sort="1" class="sort-method" href="#">Новые - Старые</a></li>
    <li class="divider"></li>
    <li><a data-sort="2" class="sort-method" href="#">Старые - Новые</a></li>
    <li class="divider"></li>
    <li><a data-sort="3" class="sort-method" href="#">По количеству лайков</a></li>
  </ul>
</div>
<a data-toggle="modal" href="#info-modal" class="btn btn-default" role="button"><span class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" title="добавить видео"></span> Добавить видео</a>
<a data-toggle="modal" href="#info-modal1" style="border: 2px solid;padding: 5px;text-decoration: none;"> <span class="glyphicon glyphicon-exclamation-sign"></span>  Правила</a>
</div>
</div>
%videos%

	<!-- Модельное окно добовления видео -->
<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span class="glyphicon glyphicon glyphicon-cloud-upload"></span> Добавить видео</h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
			<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-film"></span></span>
  <input type="text" id="video-name" class="form-control" placeholder="Название видео">
</div><br>
		<div class="input-group">
  <span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-link" ></span></span>
  <input type="text" id="video-url" class="form-control" placeholder="Вставте ссылку на видео YouTube">
</div>	<br>

<button class="btn btn-default" id="add-video" role="button"><span class="glyphicon glyphicon-plus-sign loader-changer" data-toggle="tooltip" title="добавить видео"></span> Добавить видео</button>
<br><br>
		<div class="alert alert-warning"><b>Внимание!</b> Ваше видео будет доступно только тогда, когда пройдёт модерацию. Подробнее читайте <b>ПРАВИЛА!</b>
		</div>	
	</div>
			
			
               
            </div>
        </div>
    </div>
	<!-- КОНЕЦ Модельное окно добовления видео -->
	
	
	<!-- Модельное окно правила -->
<div class="modal fade" id="info-modal1" tabindex="-1" role="dialog" aria-labelledby="stast-signal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span class="glyphicon glyphicon-exclamation-sign"></span> Правила добавления видео</h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
			
			
			<div class="panel panel-info">
			<div class="panel-heading">Основные правила публикации видео:</div>
			<div class="panel-body">
    <p><b>|</b> Запрещены видео любого рекламного характера.
</p>

<p><b>|</b>  Запрещено в видео сквернословие, а также оскорбление кого - либо.
</p>
<p><b>|</b> Запрещены аннотации в видео. 
</p>
<p><b>|</b> Запрещены видео, у которых смысл не относится к данному контенту. 
</p>


  </div>
		<div class="alert alert-warning"><b>Внимание!</b> Если Ваше видео не соответсвует правилам - оно не будет опубликовано.
		</div>	
	</div>
			
			
               
            </div>
        </div>
    </div>
</div>
	<!-- КОНЕЦ Модельное окно правила -->
	</div></div></div>
  </div>
</div>


<div class="modal fade bs-example-modal-lg" id="img-modal" tabindex="-1" role="dialog" aria-labelledby="img-signal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content m-c-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel11"><span id="article-modal">...</span></h4>
            </div>
            <div class="modal-body" id="myModalLabel11">
                <center>
                    <img id="img-modal-full" style="max-width: 850px;" class="text-center" src="" alt=""/>
                </center>
            </div>
        </div>
    </div>
</div>