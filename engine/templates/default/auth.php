<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="%root%/img/favicon-home.png">
        <link href="%root%/css/bootstrap.min.css" rel="stylesheet">
        <link href="%root%/css/home.css" rel="stylesheet">
        <link href="%root%/css/pages.css" rel="stylesheet">
        <title>%title%</title>
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
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand"><span class="title-translate">%title%</span> <div id="google_translate_element"></div></span>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="%uri%/home/support/">Контакты</a></li>
                        <li><a href="%uri%/home/brokers/">Брокеры</a></li>
                        <li><a href="%uri%/home/faq/">FAQ</a></li>
                        <li><a href="%uri%/home/stats/">Статистика</a></li>
                        <li><a href="%uri%/home/news/">Новости</a></li>
                    </ul>
                </div><!--/.navbar-collapse -->
            </div>
        </nav>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <h1>%title%</h1>
                <p>%description%</p>
                <p><a class="btn btn-default btn-lg" href="%uri%/new/" role="button">На Главную &raquo;</a></p>
            </div>
        </div>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-md-12">
                   %content%
                </div>
            </div>

            <hr>

            <div class="col-md-12 footer">
                <div class="col-md-4 text-center slideInLeft wow">
                </div>
                <div class="col-md-4 text-center slideInDown wow">
                    <h4>© Option-Signal 2015</h4>
                    <p>Мы не имеем никакого отношения к брокерам.</p>
                </div>
                <div class="col-md-4 text-center"></div>
            </div>
        </div>
    </body>
    <!-- JS -->
    <script src="%root%/js/jquery.min.js"></script>
    <script src="%root%/js/news_home.js"></script>
    <script src="%root%/js/bootstrap.min.js"></script>
    <script src="%root%/js/social.js"></script>
</html>
