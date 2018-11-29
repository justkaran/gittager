<?php
require_once 'gitConfig.php';
require_once 'header.php';
require_once 'config.php';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

$sql = "SELECT G.id, G.user, G.url, GROUP_CONCAT(T.tag) AS tags FROM gits G LEFT JOIN tags T ON T.git = G.id  WHERE G.user = ".$_SESSION['userData']['oauth_uid']." GROUP BY T.git";

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
<html lang="en-US">
<head>
    <title>GitTager</title>
    <meta charset="utf-8">
    <?php include('views/meta.php');?>
    <!-- Custom styles for this template -->
    <?php if (isset($_SESSION['userData']['username'])) {
        /*echo '<script type="text/javascript">
        mixpanel.register({
            "username": "' . $_SESSION['userData']['username'] . '",
            "email": "' . $_SESSION['userData']['email'] . '"
        });
        mixpanel.identity("'.$_SESSION['userData']['oauth_uid'].'");
        mixpanel.alias("' . $_SESSION['userData']['username'] . '");
        mixpanel.people.set_once({
            "user_id": "' . $_SESSION['userData']['username'] . '",
            "email": "' . $_SESSION['userData']['email'] . '",
            "first_name": "' . $_SESSION['userData']['name'] . '"
        });
    </script>';*/
    }
    ?>
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

<section id="about" style="box-shadow: 0px 0px 4px #ccc; padding-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto" style="background: #fff;box-shadow: 0px 0px 4px #ccc; padding-top: 1rem;border-radius: 4px;">
                <?php echo '<h3>Hi '.$_SESSION['userData']['username'].'</h3>'; ?>

                <?php

                echo '';

                echo '</div>
                            <div class="col-lg-6 mx-auto" style="background: #00b7ec;box-shadow: 0px 0px 4px #ccc; padding-top: 1rem; color:white; font-weight:bold; border-radius: 4px;">
                            </div>
                        <div class="col-lg-12 text-center">
                            &nbsp;
                        </div>

                    <div class="col-lg-12 mx-auto" style="background: #fff;box-shadow: 0px 0px 4px #ccc; padding-top: 1rem;border-radius: 4px;">';

                //var_dump($res);

                $i=1;
                if($res) {

                    echo '<h4>Your current tags</h4>';

                    while ($row = $res->fetch_assoc()) {

                        $tags = explode(",", $row['tags']);

                        echo '
                        <div style="float: left; padding-right: 1rem; padding-top: 0.5rem; width: 100%"><hr/>';

                        foreach ($tags as $tag) {
                            echo '<span class="badge badge-info">' . $tag . '</span> ';
                        }
                          echo '
                          <button type="button" class="btn-sm btn_del" data-id="'.$row['id'].'" style="float:right;margin-left: 1rem;"><i class="fas fa-trash"></i> delete</button> 
                          <a href="'.$row['url'].'" target="_blank" style="float:right;"><button type="button" class="btn-sm"><i class="fas fa-external-link-alt"></i> open</button></a>
                        </div>';

                    }
                }

                ?>
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
<script src="js/tagit.js"></script>

</body>
</html>
