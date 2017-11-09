<!doctype html>

<html lang="en" class="no-js">
<head>
    <title>%title%</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/assets/css/stroke-gap.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.bxslider.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/owl.theme.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.css" media="screen">


    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="/engine/templates/default/js/ospage.js"></script>

    <link rel="stylesheet" type="text/css" href="/assets/css/settings.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" media="screen">
</head>

<body>
<style>
    .alert-message {
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        padding: 30px;
        font-size: 1.2em;
        color: #fff;
        text-transform: uppercase;
        background: #f0937d;
        z-index: 101;
    }
    .alert-message.success {
        background-color: #74c56b;
    }
    .stats {
        overflow-x: hidden;
    }

    .notification {
        padding: 10px;
        color: #505050;
        margin-bottom: 2px;
    }
    .notification-down {
        background: rgba(249, 249, 249, 0.9);
    }
    .notification-down span {
        color: #D06363;
    }
    .notification-up {
        background: rgba(206, 206, 206, 0.78);
    }
    .notification-up span {
        color: #63A763;
    }
    .notification:last-child {
        margin-bottom: 10px;
    }
    .label-stats-0 {
        background: #D06363;
        padding: 4px;
        color: #FFF !important;
        font-size: 11px;
    }
    .label-stats-1 {
        background: #63A763;
        padding: 4px;
        color: #FFFFFF !important;
        font-size: 11px;
    }
    .stats {
        box-shadow: inset 0 2px 2px rgba(0,0,0,.3);
    }

    .broker-logo {
        height: 120px;
        background-image: url(http://trust-signals.com/engine/templates/default/img/brokers/broker1.jpg);
        background-size: cover;
        background-position: center center;
        border-radius: 4px;
    }
    .broker-table {
        display: table;
        width: 102%;
        border-spacing: 2px;
        font-size: 14px;
        margin: 0 -2px;
    }
    .broker-row {
        display: table-row;
        width: 100%;
    }
    .broker-name {
        padding: 0 10px;
    }
    .broker-value {
        width: 40px;
        text-align: center;
        padding: 10px 0;
    }
    .circle-odds.small {
        font-size: 8px;
    }
    .circle-odds {
        background-color: #ff8400;
        color: #fff;
        font-family: "RobotoBlack";
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        border-radius: 50%;
        display: block;
        margin: 0 auto;
        font-size: 12px;
    }
    .circle-odds.white {
        background-color: #F9F7F7;
        color: #FFCA90;
    }
    .broker-row > div {
        display: table-cell;
        background: #F5F5F5;
        margin: 2px;
        border-radius: 3px;
    }
    .broker-row .broker-value {
        background-color: rgba(255, 132, 0, 0.05);
    }
    .broker-el {
        width: 25%;
        float: left;
        border: 4px solid #fff;
    }
    .brokers {
        background-color: #fff;
        padding: 2px;
    }
    .brokers::after {
        content: '';
        display: block;
        clear: both;
    }
    .broker-link a.white {
        background-color: #5cce54;
        color: #fff;
    }
    .broker-link a {
        display: block;
        padding: 10px;
        background-color: #ff8400;
        border-radius: 4px;
        font-family: "Russo One";
        color: #fff;
        text-align: center;
        text-transform: uppercase;
        width: 100%;
    }




</style>
<!-- Container -->

<div id="container">

    <!-- Header

              ================================================== -->

    <header class="clearfix">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="top-line">
                <div class="container">
                    <div class="row">

                        <div class="col-md-5">
                            <ul class="social-icons">
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                                <li><a class="google" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">

                <!-- Brand and toggle get grouped for better mobile display -->

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="/"><img src="/assets/images/logo.png" alt=""></a> </div>

                <!-- Collect the nav links, forms, and other content for toggling -->

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="active" href="/">Главная</a> </li>
                        <li><a class="active" href="%uri%/home/brokers/">Брокеры</a> </li>
                        <li><a class="active" href="%uri%/home/stats/">Статистика</a> </li>
                        <li><a class="active" href="%uri%/home/faq/">FAQ</a> </li>
                        <li><a class="active" href="%uri%/home/support/">Контакты</a> </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

            </div>
            <!-- /.container -->

        </nav>
    </header>

    <!-- End Header -->

    <!-- page-banner-section

              ================================================== -->

    <section class="page-banner-section">
        <div class="text-center">
            <div class="row">
                <div class="col-md-12">
                    <h2>%page_name%</h2>
                </div>


            </div>
        </div>
    </section>



    <!-- End page-banner section -->

    <!-- contact section

              ================================================== -->

    %content%

    <!-- End contact section -->



    <!-- Buy Now

              ================================================== -->



    <!-- footer

              ================================================== -->

    <footer>

        <div class=" copyright">
            <div class="container ">
                <div class="pull-left">
                    <p class=""> &copy; 2016-2017 Trust Signals. Все права защищены, копирование материала строго запрещено! </p>
                </div>

            </div>
        </div>
    </footer>

    <!-- End footer -->

</div>

<!-- End Container -->


<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.migrate.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="/assets/js/retina-1.1.0.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins-scroll.js"></script>
<script type="text/javascript" src="/assets/js/script.js"></script>
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.migrate.js"></script>
<script type="text/javascript" src="/assets/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.isotope.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins-scroll.js"></script>
<script type="text/javascript" src="/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.countTo.js"></script>

<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->

<script type="text/javascript" src="/assets/js/script.js"></script>

</body>
</html>