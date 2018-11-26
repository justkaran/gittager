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
        $output = '<a href="logout.php"><button type="button" class="btn-lg">Logout <i class="fas fa-sign-out-alt" style="padding-left: 0.5rem; font-size: 1.5rem; line-height: 2rem; vertical-align: sub;"></i></button></a>';
        $output1 = '<a href="logout.php"><button type="button" class="btn-sm">Logout <i class="fas fa-sign-out-alt"></i></button></a>';
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }

    header('Location: ./edit.php');
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

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>CDDR Advisor</title>
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
        <div class="row startpage-bckg">
            <div class="col-lg-12 mx-auto pad10">
                <h2><b>Starting to learn how to code is easy. Being among the top developers is hard. Until now.</b></h2>
                <p class="lead"><b>No matter the source you are using to learn. We make you graduate among the top 3%. Please log in with your github account to start.</b></p>
                <p class="githublink"><?php echo $output; ?></p>
            </div>
            <div class="col-lg-3">
            </div>
        </div>
    </div>
</section>

<?php include('views/footer.php');?>

</body>
</html>
