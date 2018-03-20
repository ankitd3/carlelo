<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';
/*
 * Configuration and setup Google API
 */
$clientId = '';
$clientSecret = '';
$redirectURL = 'http://localhost:80/wt/login/'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Login');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>