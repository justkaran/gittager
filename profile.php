<?php
// Include GitHub API config file
require_once 'gitConfig.php';
require_once 'header.php';
require_once 'config.php';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

$sql = "SELECT * FROM tags WHERE user = ".$_SESSION['userData']['oauth_uid'];

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>GitTager</title>
    <meta charset="utf-8">
    <?php include('views/meta.php');?>

</head>
<body id="page-top">

<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container startpage">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <?php include('views/nav.php');?>
            <!-- Display login button / GitHub profile information -->
            <li class="nav-link"><?php echo $output1; ?></li>
        </div>
    </div>
</nav>

<section id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3" style="background: #fff;box-shadow: 0px 5px 0px #00b7ec;overflow: hidden;padding:1rem;border-radius:4px;text-align: center;">
                <!-- Display login button / GitHub profile information -->
                <?php
                echo '<img src="'.$_SESSION['userData']['picture'].'" style="max-width: 220px;"/>';
                ?>
            </div>
            <div class="col-lg-8 offset-lg-1" style="background: #fff;box-shadow: 0px 5px 0px #00b7ec; padding-top: 1rem;border-radius:4px;">
                <?php
                // Render Github profile data
                echo '<h3>Welcome to your profile '.$_SESSION['userData']['username'].'</h3>';
                ?>
                <hr style="color:#00b7ec">
                <h3 style="color:#000;">Your current status:</h3>

                <?php


                ?>

                <p id="partnerLanguages"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                &nbsp;
            </div>
        </div>
    </div>
</section>

<?php include('views/footer.php');?>

<!-- Custom JavaScript for this theme -->
<script src="js/profile.js"></script>

</body>
</html>
