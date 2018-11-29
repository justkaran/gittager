<?php
// Include GitHub API config file
require_once 'gitConfig.php';

// Include and initialize user class
require_once 'src/User.class.php';
$user = new User();

if(isset($accessToken)){
    // Get the user profile info from Github
    $gitUser = $gitClient->apiRequest($accessToken);
    if(!empty($gitUser)){
        // User profile data

        $gitUserData = array();
        $gitUserData['oauth_provider'] = 'github';
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['name'] = !empty($gitUser->name)?$gitUser->name:'';
        $gitUserData['username'] = !empty($gitUser->login)?$gitUser->login:'';
        $gitUserData['email'] = !empty($gitUser->email)?$gitUser->email:'';
        $gitUserData['location'] = !empty($gitUser->location)?$gitUser->location:'';
        $gitUserData['picture'] = !empty($gitUser->avatar_url)?$gitUser->avatar_url:'';
        $gitUserData['link'] = !empty($gitUser->html_url)?$gitUser->html_url:'';

        // Insert or update user data to the database
        $userData = $user->checkUser($gitUserData);

        // Put user data into the session
        $_SESSION['userData'] = $userData;

        // Render Github Login / Logout Button
        $output = '<a href="logout.php"><button type="button" class="btn btn-primary btn-lg">Logout <span class="ion-log-out"></span></button></a>';
        $output1 = '<a href="logout.php"><button type="button" class="btn btn-primary btn-sm">Logout <span class="ion-log-out"></span></button></a>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

}elseif(isset($_GET['code'])){
    // Verify the state matches the stored state
    if(!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
        header("Location: ".$_SERVER['PHP_SELF']);
    }
    // Exchange the auth code for a token
    $accessToken = $gitClient->getAccessToken($_GET['state'], $_GET['code']);
    $_SESSION['access_token'] = $accessToken;


    // Get the user profile info from Github
    $gitUser = $gitClient->apiRequest($accessToken);
    if(!empty($gitUser)){
        // User profile data

        $gitUserData = array();
        $gitUserData['oauth_provider'] = 'github';
        $gitUserData['oauth_uid'] = !empty($gitUser->id)?$gitUser->id:'';
        $gitUserData['name'] = !empty($gitUser->name)?$gitUser->name:'';
        $gitUserData['username'] = !empty($gitUser->login)?$gitUser->login:'';
        $gitUserData['email'] = !empty($gitUser->email)?$gitUser->email:'';
        $gitUserData['location'] = !empty($gitUser->location)?$gitUser->location:'';
        $gitUserData['picture'] = !empty($gitUser->avatar_url)?$gitUser->avatar_url:'';
        $gitUserData['link'] = !empty($gitUser->html_url)?$gitUser->html_url:'';

        // Insert or update user data to the database
        $userData = $user->checkUser($gitUserData);

        // Put user data into the session
        $_SESSION['userData'] = $userData;

        // Render Github Login / Logout Button
        $output = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn btn-primary btn-lg"><span class="ion-social-github"></span> Sign in with Github</button></a>';
        $output1 = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn btn-primary btn-sm"><span class="ion-social-github"></span> Sign in with Github</button></a>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

    header('Location: ./tags.php');
}else{
    // Generate a random hash and store in the session for security
    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
    // Remove access token from the session
    unset($_SESSION['access_token']);
    // Get the URL to authorize
    $loginURL = $gitClient->getAuthorizeURL($_SESSION['state']);
    // Render Github Login / Logout Button
    $output = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn btn-primary btn-lg"><span class="ion-social-github"></span> Sign in with Github</button></a>';
    $output1 = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn btn-primary btn-sm"><span class="ion-social-github"></span> Sign in with Github</button></a>';
}

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
                    <a class="navbar-brand scroll-link" href="#home" data-id="home"><span class="logo"><img src="images/gittager-logo.png" style="max-height: 4rem;"/></span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#home" data-id="home" class="scroll-link">Home</a></li>
                        <li><a href="#ideology" data-id="ideology" class="scroll-link">How it works</a></li>
                        <li><a href="#contact" data-id="contact" class="scroll-link">Contact</a></li>
                        <?php if (isset($_SESSION['userData']['username'])) { ?>
                            <li><a class="nav-link js-scroll-trigger" href="tags.php">Tags</a></li>
                        <?php } ?>
                        <li><?php echo $output1; ?></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </div><!-- /.container-fluid -->
    </nav>
    <!-- End Navigation -->
</header>
<!-- End Header -->

<!-- Begin Jumbotron -->
<div class="jumbotron jumbotron-main" id="home">
    <div id="particles-js"></div><!-- /.particles div -->
    <div class="container center-vertically-holder">
        <div class="center-vertically">
            <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3 text-center">
                <h1 class="scaleReveal" style="font-size: 4rem;">
                    <strong>Find and remember</strong> <br/>the best source code on github.
                </h1>
                <hr class="bottomReveal">
                <?php echo $output; ?>

            </div><!-- /.column -->
        </div><!-- /.vertical center -->
    </div><!-- /.container -->
</div>
<!-- End Jumbotron -->

<!-- Begin Intro -->
<section id="ideology">

    <!-- Begin Hello Intro -->
    <div id="hello-intro" class="pt60 pb60">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-3">
                    <h2 class="no-margin rotateLeftReveal">Hello.</h2>
                </div>
                <div class="col-lg-10 col-sm-9 mt30-xs">
                    <h3 class="no-margin rightReveal">You are looking for the best source code on github? You are looking for a way to remember what you found on github. <strong>Gittager is your tool!</strong></h3>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.div -->
    <!-- End Hello Intro -->

    <!-- Begin Our Process Title -->
    <div id="our-process-title" class="pt30 pb30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h4 class="no-margin">How it works</h4>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.div -->
    <!-- End Our Process Title -->

    <!-- Begin Our Process -->
    <div id="our-process">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 process-box text-center pt50 pb50">
                    <div class="leftReveal">
                        <div class="process-intro">
                            <h3 class="process-number">01</h3>
                            <div><span class="process-icons pe-7s-link rotateBottomReveal"></span></div>
                            <h2>Install <br>Bookmarklet</h2>
                        </div>
                        <div class="process-content">
                            <div><span class="process-icons pe-7s-link"></span></div>
                            <h2 class="mt15 mb20">Install<br>Bookmarklet</h2>
                            <p class="no-margin">Install GitTager bookmarklet for easy taging. <button id="bmcopy" class="btn btn-default btn-sm" style="margin-top: 1rem;" data-toggle="tooltip" data-placement="top" title="copied bookmarklet to clipboard"><span class="ion-ios-copy"></span> copy bookmarklet</button></p>
                        </div>
                    </div><!-- /.animation -->
                </div><!-- /.column -->
                <div class="col-sm-4 col-md-4 col-lg-4 process-box text-center pt50 pb50">
                    <div class="bottomReveal">
                        <div class="process-intro">
                            <h3 class="process-number">02</h3>
                            <div><span class="process-icons pe-7s-map-marker rotateBottomReveal"></span></div>
                            <h2>Tag best practise<br>source code on github</h2>
                        </div>
                        <div class="process-content">
                            <div><span class="process-icons pe-7s-map-marker"></span></div>
                            <h2 class="mt15 mb20">Tag best practise<br>source code on github</h2>
                            <p class="no-margin">Tag all best practise source codes you find to collect them on your gittager.</p>
                        </div>
                    </div><!-- /.animation -->
                </div><!-- /.column -->
                <div class="col-sm-4 col-md-4 col-lg-4 process-box text-center pt50 pb50 no-border-right">
                    <div class="rightReveal">
                        <div class="process-intro">
                            <h3 class="process-number">03</h3>
                            <div><span class="process-icons pe-7s-share rotateBottomReveal"></span></div>
                            <h2>Find all your (and others) Tags<br>in GitTager</h2>
                        </div>
                        <div class="process-content">
                            <div><span class="process-icons pe-7s-share"></span></div>
                            <h2 class="mt15 mb20">Find all your (and others) Tags<br>in GitTager</h2>
                            <p class="no-margin">Use your collection of best practise source codes or search in others tags collections.</p>
                        </div>
                    </div><!-- /.animation -->
                </div><!-- /.column -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.div -->
    <!-- End Our Process -->

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
</body>
</html>
