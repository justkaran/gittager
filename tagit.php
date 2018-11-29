<?php
require_once 'gitConfig.php';
require_once 'header.php';
require_once 'config.php';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
if (!$conn) {
    die('Connection failed ' . mysqli_error($conn));
}

$sql = "SELECT * FROM sources WHERE user = ".$_SESSION['userData']['oauth_uid'];

$res = mysqli_query($conn, $sql);

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

<section id="about" style="box-shadow: 0px 0px 4px #ccc; padding-top: 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto" style="background: #fff;box-shadow: 0px 0px 4px #ccc; padding-top: 1rem;border-radius: 4px;">
                <?php echo '<h3>Hi '.$_SESSION['userData']['username'].'</h3>'; ?>
                <hr style="height: 1px; background: #00b7ec">
                <div id="maincontent">Want to tag: <code><?php echo $_GET['titel'];?></code> <br/>
                with:<br/>
                <textarea rows="3" cols="50" id="tags">#best practise, #<?php echo $_GET['titel'];?></textarea>
                <br/><br/>

                <?php $url = str_ireplace("***", "#", $_GET['permalink']); ?>

                <button type="button" id="btn_add" class="btn-sm btn-add" data-value="1" data-url="<?php echo $url;?>" data-usr="<?php echo $_SESSION['userData']['oauth_uid'];?>"><i class="fas fa-save"></i> TAG it</button>
                    <p>&nbsp;</p></div>
                <hr style="height: 1px; background: #00b7ec">
                <?php

                //var_dump($res);

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
