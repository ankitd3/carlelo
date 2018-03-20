<?php
//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

if(isset($_GET['code'])){
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	//Get user profile data from google
	$gpUserProfile = $google_oauthV2->userinfo->get();
	
	//Initialize User class
	$user = new User();
	
	//Insert or update user data to the database
    $gpUserData = array(
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'picture'       => $gpUserProfile['picture'],
        'email'         => $gpUserProfile['email'],
    );
    $userData = $user->checkUser($gpUserData);
	
	//Storing user data into session
	$_SESSION['userData'] = $userData;
	
	//Render facebook profile data
    if(!empty($userData)){
        header("location:../maincopy.php"); //redirect to home
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }


} else {
	$authUrl = $gClient->createAuthUrl();
	$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><div class="login">
  <header class="header">
    <span class="text">LOGIN</span>
    <span class="loader"></span>
  </header>
               <img src="images/glogin.png" alt=""/>
</div></a>';
}
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> carlelo-login</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="css/style.css">
  <style type="text/css">
    body{
      background: url(../images/back1.jpg) no-repeat center center fixed;
            background-size: cover;
    }
    #left, #right {
      background: white;
      position: fixed;
      top: 0; bottom: 0;
      width: 10px;
    }
    #left { left: 0; }
    #right { right: 0; }

    .footer {
       position: fixed;
       left: 0;
       bottom: 0;
       width: 100%;
       background-color: white;
       color: #000;
       text-align: center;
       font-family:"Courier New", monospace;
       font-size: 124%;
    }
    hr{height: 6px}
    h1{font-family:"Courier New", Courier, monospace;color: white;font-weight: normal;font-size:275%;}
    html, body {height:100%;}
    html {display:table; width:100%;}
    body {display:table-cell; text-align:center;}
  </style>
</head>
<body>
  <div id="left"></div>
  <div id="right"></div>
  <hr color="white">
      <br><h1>WELCOME TO CARLELO.com</h1>
  <hr color="white"><br>
  <div><?php  echo $output; ?></div>

  <div class="footer">
    <p><b>-One stop solution to car renting-</b></p>
  </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="js/index.js"></script>
</body>
</html>