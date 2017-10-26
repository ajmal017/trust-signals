

<head>
<link href="/engine/templates/default/css/style-262.css" rel="stylesheet">


		<!-- Font awesome CSS -->
		<link href="/engine/templates/default/css/font-awesome.min.css" rel="stylesheet">


</head>

<div>
  <ul class="nav nav nav-pills" role="tablist" style="background: #F9F9F9;
    padding: 5px;">
    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><i class="fa fa-signal"></i> Сигналы 1-3М</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><i class="fa fa-signal"></i> Сигналы 15М</a></li>
    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"> <i class="fa fa-signal"></i> Сигналы 30М</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1">
	
	
	<!-- UI X -->
		<div class="ui-262">
			<div class="container">
				<!-- UI content -->
				<div class="block-content" style="margin-top: 14px;">
					<div class="row" id="eurusd" >
						
							
				
								
								
						
				
				
				
				
				
				
			</div>
		</div>	

	<div class='hidden-xs' style='position: absolute;
    margin-top: -70px;
    right: 1%; '>
								<a  data-toggle="modal" href="#news-modal"class='facebook' style='    padding: 15px 5px;
    color: white;     margin-right: 5px;'>
										<i class='fa fa-calendar'></i> Новости
										
									</a>
									
									<a data-toggle="modal" href="#graf-modal" class='google-plus' style='    padding: 15px 5px;
    color: white;  margin-right: 5px;'>
										<i class='fa fa-bar-chart'></i> График
										
									</a>
									
									<a data-toggle="modal" href="#info-modal"class='linkedin' style='    padding: 15px 5px;
    color: white;'>
										<i class='fa fa-info-circle'></i> Инфо
										
									</a>
									
									
							</div>


		
			</div>
		</div>
		
		
		
		
		
		
		<!-- UI X -->
		
		
		
		
						
								
							
						
		
		
		
		
		
		
		
		
		<div class="bs-example" style="    background: rgba(249, 249, 249, 0.72);
    padding: 8px;
    margin-top: -28px;"> <div>Индикатор давления EUR/USD </div>
	<div class="progress" id="indikator" style="padding-left: 7px;" >
		
	</div>
</div>
	
	<div class="bs-example">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Simbol</th>
          <th>Время выхода</th>
          <th>Цена</th>
		  <th>Направление</th>
          <th>Результат</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>EUR/USD</td>
          <td>12:43(МСК)</td>
          <td>0.4579</td>
		  <center><td><i class='fa fa-arrow-circle-up' style="color:green; font-size: 18px;margin-left: 20%;"></i></td></center>
          <td style="color:green">WIN | 0.4582</td>
        </tr>
        <tr>
          <td>EUR/USD</td>
          <td>12:53(МСК)</td>
          <td>0.4589</td>
		  <center><td><i class='fa fa-arrow-circle-down' style="color:red; font-size: 18px;margin-left: 20%;"></i></td></center>
          <td style="color:red">LOST | 0.4587</td>
        </tr>
		<tr>
          <td>EUR/USD</td>
          <td>12:58(МСК)</td>
          <td>0.4581</td>
		  <center><td><i class='fa fa-arrow-circle-up' style="color:green; font-size: 18px;margin-left: 20%;"></i></td></center>
          <td style="color:green">WIN | 0.4582</td>
        </tr>
      </tbody>
    </table>
  </div>
	

<!--   СКРИПТ ОБНОВЛЕНИЕ БЛОКА.
<script>
setInterval(function(){
$("#west").load("/engine/templates/default/pages/elly.php #west");
}, 3000); 
</script>
-->

	 <script>  
        function show()  
        {  
            $.ajax({  
                url: "/engine/templates/default/pages/sk.php",  
                cache: false,  
                success: function(html){  
                    $("#eurusd").html(html);  
                }  
            });  
        }  
      
        $(document).ready(function(){  
            show();  
            setInterval('show()',45000);  
        });  
    </script>  
	
	<script>  
        function show1()  
        {  
            $.ajax({  
                url: "/engine/templates/default/pages/indikator.php",  
                cache: false,  
                success: function(html){  
                    $("#indikator").html(html);  
                }  
            });  
        }  
      
        $(document).ready(function(){  
            show1();  
            setInterval('show1()',45000);  
        });  
    </script>  
	</div>
	
	
	
    <div role="tabpanel" class="tab-pane" id="tab2">2</div>
    <div role="tabpanel" class="tab-pane" id="tab3">3</div>
  </div>
</div>


<!-- NEWS -->
<div class="modal fade" id="graf-modal" tabindex="-1" role="dialog" aria-labelledby="news-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">EUR/USD</h4>
            </div>
            <div class="modal-body" style='padding: 0px; 
    height: 350px;'>
               <!-- TradingView Widget BEGIN -->
<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
<script type="text/javascript">
new TradingView.widget({
  "autosize": true, 
  "symbol": "FX:EURUSD",
  "interval": "1",
  "timezone": "UTC",
  "theme": "Black",
  "style": "1",
  "toolbar_bg": "#f1f3f6",
  "hide_top_toolbar": true,
  "save_image": false,
  "hideideas": true,
  "studies": [ "ROC@tv-basicstudies",
	"StochasticRSI@tv-basicstudies",
	"MASimple@tv-basicstudies" ],
});
</script>
<!-- TradingView Widget END -->
            </div>
        </div>
    </div>
</div>
	<!-- NEWS -->
	
	
	<!-- grafik -->
	
	<div class="modal fade" id="news-modal" tabindex="-1" role="dialog" aria-labelledby="news-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Экономические новости</h4>
            </div>
            <div class="modal-body">
                <iframe src="http://ec.ru.forexprostools.com?columns=exc_flags,exc_currency,exc_importance,exc_actual,exc_forecast,exc_previous&category=_employment,_economicActivity,_inflation,_credit,_centralBanks,_confidenceIndex,_balance,_Bonds&importance=1,2,3&features=timezone&countries=25,4,17,39,72,26,10,6,37,97,43,56,36,5,61,22,12,89,110,35&calType=day&timeZone=18&lang=7"
                        width="100%" height="375px" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0"></iframe>
            </div>
        </div>
    </div>
</div>
	<!-- grafik -->
	
	
	
	<!-- info -->
	
	<div class="modal fade" id="info-modal" tabindex="-1" role="dialog" aria-labelledby="news-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ИНФО</h4>
            </div>
            <div class="modal-body">
                
				<div>Информация</div>
				
				
            </div>
        </div>
    </div>
</div>
	<!-- info -->
	
	
	
	
	
	
	
	
