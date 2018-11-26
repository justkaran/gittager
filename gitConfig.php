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
$clientID         = '85e411f0fc7beeaeac8d';
$clientSecret     = 'b8f3e3661dc0335273ac2696f73a14ba5c63ad1e';
$redirectURL     = 'http://cddr.ninja/';

$gitClient = new Github_OAuth_Client(array(
    'client_id' => $clientID,
    'client_secret' => $clientSecret,
    'redirect_uri' => $redirectURL,
));


// Try to get the access token
if(isset($_SESSION['access_token'])){
    $accessToken = $_SESSION['access_token'];
}
