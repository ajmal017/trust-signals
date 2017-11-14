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
    <link href="/engine/templates/default/css/orange_windows.css" rel="stylesheet">
    <link href="/engine/templates/default/css/home_orange.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/settings.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" media="screen">
</head>
<body>
<style>
</style>
<!-- Container -->
<div id="content-window">
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
                        <a class="navbar-brand" href="/"><img src="/assets/images/logo.png" alt=""></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            {orange/menu.php}
                            <!-ifAUTH>
                            <!-end>
                            <!-else>
                            <li class="hidden-list open-auth"><a href="#">Войти</a></li>
                            <li class="hidden-list open-reg"><a href="#" class="sp_notify_prompt">Регистрация</a></li>
                            <!-endelse>
                        </ul>
            </nav>
    </div>
    <div class="header-auth">
        <!-ifAUTH>
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
</div>
{orange/windows.php}
<!-- End Container -->
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.migrate.js"></script>
<script type="text/javascript" src="/assets/js/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.isotope.min.js"></script>
<script type="text/javascript" src="/assets/js/plugins-scroll.js"></script>
<script type="text/javascript" src="/assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.countTo.js"></script>
<script type="text/javascript" src="/engine/templates/default/js/home_orange.js"></script>
<script src="/engine/templates/default/js/ion.rangeSlider.min.js"></script>
<script src="/engine/templates/default/js/waypoint.js"></script>
<script src="/engine/templates/default/js/ospage.js"></script>
<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script type="text/javascript" src="/assets/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="/assets/js/script.js"></script>
</body>
</html>