<?php

if(isset($accessToken)){

    if(!empty($_SESSION['userData'])){
        // Render Github Login / Logout Button
        $output = '<a href="logout.php"><button type="button" class="btn-lg">Logout <i class="fas fa-sign-out-alt" style="padding-left: 0.5rem; font-size: 1.5rem; line-height: 2rem; vertical-align: sub;"></i></button></a>';
        $output1 = '<a href="logout.php"><button type="button" class="btn-sm">Logout <i class="fas fa-sign-out-alt"></i></button></a>';
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
    $output = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn-lg"><i class="fab fa-github" style="padding-right: 0.5rem; font-size: 1.5rem; line-height: 2rem; vertical-align: sub;"></i> Login with Github</button></a>';
    $output1 = '<a href="'.htmlspecialchars($loginURL).'"><button type="button" class="btn-sm"><i class="fab fa-github"></i> Login with Github</button></a>';
}
?>
