<?php
// Start session
if(!session_id()){
    session_start();
}

// Include Github client library
require_once 'src/Github_OAuth_Client.php';


/*
 * Configuration and setup GitHub API
 */
$clientID         = 'Iv1.ae6b7174cd275cd6';
$clientSecret     = '2c3ce5f0f84c9ce222ae7398faeadffd5cf30c61';
$redirectURL     = 'http://www.gittager.com/';

$gitClient = new Github_OAuth_Client(array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectURL,
));


// Try to get the access token
if(isset($_SESSION['access_token'])){
    $accessToken = $_SESSION['access_token'];
}
