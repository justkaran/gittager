<?php

if(isset($accessToken)){

    if(!empty($_SESSION['userData'])){
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
