<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="%meta_d%">
        <meta name="keywords" content="%meta_k%">
        <link rel="icon" id="pulse-icon" href="%root%/img/favicon-basic.png">
        <title>%title%</title>
        <!-- CSS -->
        <link href="%root%/css/bootstrap.min.css" rel="stylesheet">
        <link href="%root%/css/main.css" rel="stylesheet">
        <link href="%root%/css/profile.css" rel="stylesheet">
        <link href="%root%/css/mails.css" rel="stylesheet">
        <link href="%root%/css/notification.css" rel="stylesheet">
        <link href="%root%/css/key.css" rel="stylesheet">
        <link href="%root%/css/faq.css" rel="stylesheet">
        <link href="%root%/css/users-signals.css" rel="stylesheet">
        <link href="%root%/css/signals.css" rel="stylesheet">
        <link href="%root%/css/checkbox.css" rel="stylesheet">
        <link href="%root%/css/progress.css" rel="stylesheet">
        <link href="%root%/css/vip.css" rel="stylesheet">
        <link href="%root%/css/buy.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
        <-if css=`%uri%/admin/`>%root%/css/panel.css<-end>
        <link href="%root%/css/ion.rangeSlider.css" rel="stylesheet">
        <link href="%root%/css/ion.rangeSlider.normalize.css" rel="stylesheet">
        <link href="%root%/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
        <link href="%root%/css/style-254.css" rel="stylesheet">
        <-if css=`%uri%/elly/`>%root%/css/style-262.css<-end>
        <link href="%root%/css/font-awesome.min.css" rel="stylesheet">
        <link href="%root%/css/elly.css" rel="stylesheet">
        <-if css=`%uri%/web/`>%root%/css/web.css?t=2<-end>
        <-if css=`%uri%/binomo/`>%root%/css/web.css?t=2<-end>
        <-if css=`%uri%/binomo/`>%root%/css/binomo.css?t=2<-end>
    </head>
    <body>
        {google_translate.php}
        <style>
            .title-translate {
                float: left;
            }
            .goog-te-combo {
                margin: 0 !important;
                margin-left: 20px !important;
            }
        </style>
        <div class="container-fluid">
            <!-- HEADER     -->
                {header.php}
            <!-- HEADER END -->
            <div class="row">
                <!-- SIDEBAR     -->
                    <div class="col-md-3 sidebar">
                        {sidebar.php}
                    </div>
                <!-- SIDEBAR END -->
                <!-- CONTENT     -->
                    {elly/audio.php}
                    <div class="col-md-9 content">
                        {title.php}
                        <div class="col-md-12" id="content">
                            %content%
                        </div>
                    </div>
                <!-- CONTENT END -->
                <!-- FOOTER     -->
                    {footer.php}
                <!-- FOOTER END -->
            </div>
        </div>
    </body>
    {cabinet/outmodal.php}
    <!-- JS -->
    <script src="%root%/js/jquery.min.js"></script>
    <script src="%root%/js/bootstrap.min.js"></script>
    <script src="%root%/js/ajaxupload.js"></script>
    <script src="%root%/js/main.js"></script>

    <script src="%root%/js/checkbox.min.js"></script>
    <script src="%root%/js/update-values.js"></script>
    <script src="%root%/js/cookie.js"></script>

    <!-- SPECIAL JS     -->
        <-if address=`%uri%/profile/`>%root%/js/profile.js<-end>
        <-if address=`%uri%/mails/`>%root%/js/mails.js<-end>
        <-if address=`%uri%/notification/`>%root%/js/notification.js<-end>
        <-if address=`%uri%/key/`>%root%/js/key.js<-end>
        <-if address=`%uri%/support/`>%root%/js/support.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/jquery-asPieProgress.min.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/user-signals.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/jquery.countdown360.min.js<-end>
        <-if address=`%uri%/vip/`>%root%/js/jquery.countdown360.min.js<-end>
        <-if address=`%uri%/cabinet/`>https://d33t3vvu2t2yu5.cloudfront.net/tv.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/cabinet.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/settings-cabinet.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/jquery.imgareaselect.pack.js<-end>
        <-if address=`%uri%/cabinet/`>%root%/js/ion.rangeSlider.min.js<-end>
        <-if address=`%uri%/elly/`>%root%/js01/jquery.flot.min.js<-end>
        <-if address=`%uri%/elly/`>%root%/js01/jquery.flot.resize.min.js<-end>
        <-if address=`%uri%/elly/`>%root%/js01/jquery.knob.min.js<-end>
        <-if address=`%uri%/elly/`>%root%/js/elly.js<-end>
        <-if address=`%uri%/web/`>%root%/js/web.js?t=2<-end>
        <-if address=`%uri%/binomo/`>%root%/js/binomo.js?t=2<-end>
        <-if address=`%uri%/stats/`>%root%/js/stats.js<-end>
        <-if address=`%uri%/strategies/`>%root%/js/strategies.js<-end>
        <-if address=`%uri%/vip/`>https://d33t3vvu2t2yu5.cloudfront.net/tv.js<-end>
        <-if address=`%uri%/vip/`>%root%/js/vip.js<-end>
        <-if address=`%uri%/vip/`>%root%/js/settings-vip.js<-end>
        <-if address=`%uri%/vip/`>%root%/js/ion.rangeSlider.min.js<-end>
        <-if address=`%uri%/vip/`>%root%/js/changetimevip.js<-end>
        <-if address=`%uri%/strategies/`>%root%/js/changetimevip.js<-end>
        <-if address=`%uri%/news_home/`>%root%/js/news_home.js<-end>
        <-if address=`%uri%/elly/`>%root%/js/changetimevip.js<-end>
        <-if address=`%uri%/buy/`>%root%/js/buy.js<-end>
        <-if address=`%uri%/analysis/`>%root%/js/analysis.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/news_home.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/windows.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/jquery.maskedinput.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/settings.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/bonuses.js<-end>
        <-if address=`%uri%/fq/`>%root%/js/fq.js<-end>
        <-if address=`%uri%/fq_elly/`>%root%/js/fq_elly.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/news.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/supp.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/orders.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/users.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/includes.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/patterns.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/strategies.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/add-strategy.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/add-news.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/jquery.nicescroll.min.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/placeholder.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/respond.min.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/html5shiv.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/loadimgstr.js<-end>
        <-if address=`%uri%/admin/`>%root%/js/loadimgnews.js<-end>
        <-if address=`%uri%/admin/`>%root%/ckeditor/ckeditor.js<-end>
    <!-- SPECIAL JS END -->
</html>
