<div class="row">
    <div class="col-md-12 title-box">
        <div class="row">
        <script type="text/javascript" src="/engine/templates/default/js/jquery.min.js"></script>
            <div class="col-md-9">
                <p class="title-path"><span>Время на сервере</span><span id="content1" style="background: rgba(255, 0, 0, 0);
    color: #5D5D5D;"></span></p>
                <script>
 function show55()
 {
    $.ajax({
   url: "//trust-signals.com/engine/templates/default/times.php",
   cache: false,
   success: function(html){
    $("#content1").html(html);
   }
    });
 }

 $(document).ready(function(){
    show55();
    setInterval('show55()',15000);
 });
</script>



                <h3>
                    <span class="title-translate"><span class="glyphicon glyphicon-file"></span>
                        <span class="page-name">%title_content%</span>
                    </span>
                    %switch_types%
                </h3>
            </div>
            <div class="col-md-3 last-time">
                <h1 class="col-md-4 col-sm-1 col-xs-2 text-left">
                 <img src="%root%/img/face3.png" style="position: absolute;">
                    <img src="%root%/img/clock.png" class="clock-box-img %start_class%" style="margin-left: 7px;
    margin-top: 3px;" alt=""/>
                </h1>
                <h1 class="col-md-8 col-sm-11 col-xs-10 text-left">
                    <p class="time-data-title">
                        <a href="https://trust-signals.com/buy/"><small class="timeleft-vip" data-toggle="tooltip" data-placement="top" title="Время в VIP кабинете">%lasttime_vip%</small><a>
                    </p>
                    <p>
                       <a href="https://trust-signals.com/buy/"> <small class="timeleft-cabinet" data-toggle="tooltip" data-placement="top" title="Время в базовом кабинете">%lasttime%</small></a>
                    </p>
                </h1>
            </div>
        </div>
    </div>
</div>