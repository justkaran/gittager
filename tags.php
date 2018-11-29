<?php
require_once 'gitConfig.php';
require_once 'header.php';
require_once 'config.php';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

$sql = "SELECT G.id, G.user, G.url, GROUP_CONCAT(T.tag) AS tags, G.note FROM gits G LEFT JOIN tags T ON T.git = G.id  WHERE G.user = ".$_SESSION['userData']['oauth_uid']." GROUP BY T.git";

$res = mysqli_query($conn, $sql);

/*
$apiURL = "https://api.github.com/users/".$_SESSION['userData']['username']."/repos";
$context  = stream_context_create([
    'http' => [
        'user_agent' => 'gittager',
        'header' => 'Accept: application/json'
    ]
]);
$response = @file_get_contents($apiURL, false, $context);

$response = $response ? json_decode($response) : $response;

$urls = array_map(function($item) {
    return array($item->name, $item->html_url);
}, $response);

//var_dump($urls);
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('views/meta.php');?>

</head>
<body class="royal_preloader" data-spy="scroll" data-target=".navbar" data-offset="70">
<div id="royal_preloader"></div>

<!-- Begin Header -->
<header>
    <!-- Begin Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="row">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php#home" data-id="home"><span class="logo"><img src="images/gittager-logo.png" style="max-height: 4rem;"/></span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php include('views/nav.php');?>
                        <li><?php echo $output1; ?></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <!-- End Navigation -->
</header>
<!-- End Header -->

<!-- Begin Intro -->
<section id="ideology">

    <!-- Begin Our Process Title -->
    <div id="our-process-title" class="pt30 pb30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4 class="no-margin">Your current tags</h4>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.div -->
    <!-- End Our Process Title -->


        <div class="container">
            <div class="row">
                <!-- column -->
                <div class="col-sm-12 mt30-xs">
                    <p class="text-small mt50 no-margin-bottom">Here you find all your tags, can open the github or delete tags:</p>

 <?php

                    echo '';

                    echo '
                    <div>';

                    //var_dump($res);

                    $i=1;
                    if($res) {

                        while ($row = $res->fetch_assoc()) {

                            $tags = explode(",", $row['tags']);

                            echo '
                        <div style="float: left; padding-right: 1rem; padding-top: 0.5rem; width: 100%"><hr class="bottomReveal" data-sr-id="1" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 1.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0.05s, opacity 1.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0.05s; transition: transform 1.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0.05s, opacity 1.5s cubic-bezier(0.6, 0.2, 0.1, 1) 0.05s; ">';

                            foreach ($tags as $tag) {
                                echo '<span class="label label-primary">' . $tag . '</span> ';
                            }
                            echo '
                          <button type="button" class="btn btn-primary btn-sm btn_del" data-id="'.$row['id'].'" style="float:right;margin-left: 1rem;"><i class="fas fa-trash"></i> delete</button> 
                          <a href="'.$row['url'].'" target="_blank" style="float:right;margin-left: 1rem;"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-external-link-alt"></i> open</button></a>
                          <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseNotes'.$row['id'].'" aria-expanded="false" aria-controls="collapseNotes'.$row['id'].'" style="float: right;margin-left: 1rem;"';
                            if ($row['note'] == '') echo ' disabled';
                    echo '>
                        show notes
                        </button>

                    <div class="collapse" id="collapseNotes'.$row['id'].'" style="width: 100%;margin-top: 3.6rem;">
                            <div class="panel panel-primary">
                            <div class="panel-body">
                            '.$row['note'].'
                            </div>
                            </div>
                    </div>
                        </div>';

                        }
                    }

                    ?>
                </div>


                </div><!-- /.column -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    &nbsp;
                </div>
            </div>
        </div><!-- /.container -->


</section><!-- /.section -->
<!-- End Intro -->

<!-- Begin Contact -->
<section id="contact" class="background2 section-padding">
    <div class="container">
        <div class="row mb30">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 section-title text-center">
                <h2>Contact</h2>
                <span class="section-divider mb15"></span>
                <p class="no-margin scaleReveal">info@gittager.com</p>
            </div><!-- /.column -->
        </div><!-- /.row -->

    </div><!-- /.container -->
</section><!-- /.section -->
<!-- End Contact -->

<!-- Begin Map
<div id="map"></div>
 End Map -->

<!-- Begin Footer -->
<footer class="footer-padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <a href="http://codedoor.org/imprint.html">imprint</a> -
                <a href="http://codedoor.org/">about us</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-small text-center">
                <hr>
                <button type="button" class="btn btn-primary btn-up-footer btn-sm scroll-top">Up</button>
                <p class="no-margin">&copy; CodeDoor.org</p>
            </div><!-- /.column -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</footer><!-- /.footer -->
<!-- Begin Footer -->

<!-- Javascript Files -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArLNT3t4qsJEBmR0R9P_6ueLIQz0Jvt1M&callback=initMap" async defer></script>
<script type="text/javascript">
    /* ---- Google Maps ---- */
    function initMap() {
        var mapOptions = {
            zoom: 15,
            zoomControl: false,
            scaleControl: false,
            scrollwheel: false,
            disableDoubleClickZoom: true,
            center: new google.maps.LatLng(40.6700, -73.9400), // New York
            styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
        };
        var mapElement = document.getElementById('map');
        var map = new google.maps.Map(mapElement, mapOptions);
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(40.6700, -73.9400),
            map: map,
            title: 'Our Office!'
        });
    }
</script>
<script type="text/javascript" src="js/particles.min.js"></script>
<script type="text/javascript" src="js/particlesRun.js"></script>
<script type="text/javascript" src="js/jquery.mixitup.js"></script>
<script type="text/javascript" src="js/form-validator.min.js"></script>
<script type="text/javascript" src="js/jquery.inview.min.js"></script>
<script type="text/javascript" src="js/jquery.countTo.js"></script>
<script type="text/javascript">
    /* ---- Counter (our count) ---- */
    $('#ourcount').one('inview', function(event, isInView) {
        if (isInView) {
            $('.timer').countTo({speed: 3000});
        }
    });

    $("#bmcopy").click(function(){
        $("#bookmarklettext").select();
        document.execCommand('copy');
        $('#bmcopy').tooltip('show');
    });
</script>
<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="js/scrollreveal.min.js"></script>
<script type="text/javascript" src="js/style-switcher.js"></script><!-- Remove for production -->
<script type="text/javascript" src="js/main.js"></script>
<textarea id="bookmarklettext" style="position: absolute; left: -9999px;">javascript: link="http://www.gittager.com/tagit.php?permalink=" + document.getElementById('js-copy-permalink').value.replace("#", "***") + "&titel=" + document.querySelector("meta[property='og:title']").getAttribute("content"); meinpopup=open(link,'_blank','width=605,height=555'); meinpopup.focus(); void(0);</textarea>
<script src="js/tagit.js"></script>
</body>
</html>
