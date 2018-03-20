<?php
SESSION_start();
$var='';
$var1='';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carlelo";
date_default_timezone_set('Asia/Kolkata');
$current_datetime = date('Y-m-d H:i:s');
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$e=$_SESSION['userData']['email'];
if (isset($_POST["car_id"])) {
      $carid=$_POST["car_id"];
      $pick=$_POST["pick_date"].' '.$_POST["pick_time"].':00';
      $drop=$_POST["drop_date"].' '.$_POST["drop_time"].':00';
      $_SESSION['pick']=$pick;
      $_SESSION['drop']=$drop;
      $_SESSION['carid']=$carid;
      $t1 = StrToTime ( $drop );
      $t2 = StrToTime ( $pick );
      $diff = $t1 - $t2;
      $hours = $diff / ( 60 * 60 );

      $sql2 = "SELECT base_amt,name FROM car WHERE ($carid=car_id)";
      $result2 = $conn->query($sql2);

      if ($result2->num_rows > 0) {
          // output data of each row
          while($row = $result2->fetch_assoc()) {
              $base=$row["base_amt"];
          }
      }
      $totalamount=$hours*$base;
      $totalamount=round($totalamount);
      $_SESSION['totalamount']=$totalamount;
      if($pick>=$current_datetime && $hours>0)
      {
      $sql1 = "SELECT * FROM booking WHERE ($carid = car_id) AND (('$pick' BETWEEN pickup AND drop_car) OR ('$drop' BETWEEN pickup AND drop_car))";
      $result = $conn->query($sql1);
      if ($result->num_rows > 0) {
          $var1= "THE REQUESTED CAR IS UNAVAILABLE, PLEASE TRY AGAIN WITH DIFFERENT VALUES.<br><br>";
          $sql3 = "SELECT * FROM car WHERE car_id NOT IN (SELECT car_id FROM booking WHERE (('$pick' BETWEEN pickup AND drop_car) OR ('$drop' BETWEEN pickup AND drop_car)))";
          $result3 = $conn->query($sql3);
          if ($result3->num_rows > 0) {
              // output data of each row
              $var1 .= "OTHER CARS AVAILABLE DURING THE PERIOD:<br><br>";
              while($row = $result3->fetch_assoc()) {
                  $var1 .= "CAR id: ".$row["car_id"]. "  Name: ".$row["name"]." with Rs.".$row["base_amt"]."/hr<br>";
              }
          } else {
              $var1 .= "SORRY NO CARS AVAILABLE DURING THIS PERIOD";
          }
          $var='';
          }
      else{
            $var1 = 'CAR CHOSEN with ID :  <strong>'.$carid.'</strong> (Good choice :))';
            $var1 .= '<br/> Base AMOUNT per hour : <strong>Rs.' . $base.'/-</strong>';
            $var1 .= '<br/> Number of hours you wished to drive : <strong>'.$hours.' hours</strong>';
            $var1 .= '<br/><br/>Total AMOUNT is <strong>Rs.'.$totalamount.'/-</strong> Please pay to confirm!';
            $var='<form action="action_page.php" method="post" name="submit"><button type="submit" style="display: inline-block;
            padding: 15px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #2196F3;
            border: none;
            border-radius: 25px;
            margin:auto;
            box-shadow: 0 9px #999;">PAYMENT</button></form>';            
      }
    }
      elseif($hours<=0) {$var1 = 'Please pick our car before you plan to drop it!!';}
      elseif($pick<$current_datetime) {$var1='“Sooner or later we\'ve all got to let go of our past."<br> 
― Dan Brown<br><br>Please try booking in future!';}
}
else{
    $pick=$_SESSION['pick'];
    $drop=$_SESSION['drop'];
    $carid=$_SESSION['carid'];
    $totalamount=$_SESSION['totalamount'];
    $sql = "INSERT INTO booking (car_id,email,pickup,drop_car,amount)
            VALUES ('$carid','$e','$pick','$drop','$totalamount')";

            if ($conn->query($sql) === TRUE) {
                header("location:mybooking.php");
            }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<title>booking</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
.mySlides {display:none}
body{
  background: url(images/back.jpg) no-repeat center center fixed;
        background-size: cover;
}
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}
</style>
<body class="w3-content w3-border-left w3-border-right">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-light-grey w3-collapse w3-top" style="z-index:3;width:260px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright"></i>
    <h2 class="w3-text-blue">CARLELO.COM</h2>
    <h3>Rent cars from</h3>
    <h6>Rs 299 per hour</h6>
    <hr>
    <form action="action_page.php" method="post">
      <p><label><i class="fa fa-car"></i> CAR ID</label></p>
      <input class="w3-input w3-border" type="text" placeholder="Enter ID" name="car_id" pattern="[0-9]{3}" title="3 digit ID" required>
      <p><label><i class="fa fa-calendar-check-o"></i> PICK UP</label></p>
      <input class="w3-input w3-border" type="date" name="pick_date" required>
      <p><label><i class="fa fa-star"></i> PICK UP TIME</label></p>
      <input class="w3-input w3-border" type="time" name="pick_time" required>
      <p><label><i class="fa fa-calendar-o"></i> DROP OFF</label></p>
      <input class="w3-input w3-border" type="date" name="drop_date" required>   
      <p><label><i class="fa fa-star"></i> DROP OFF TIME</label></p>
      <input class="w3-input w3-border" type="time" name="drop_time" required>
      <p><button class="w3-button w3-block w3-blue w3-left-align" type="submit"><i class="fa fa-search w3-margin-right"></i> BOOK</button></p>
    </form>
  </div>
  <div class="w3-bar-block">
    <a href="maincopy.php" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-car"></i> Car Profile</a>
    <a href="rules.php" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-times"></i> Rules</a>
    <a href="about.php" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-info"></i> About US</a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-16" onclick="document.getElementById('subscribe').style.display='block'"><i class="fa fa-rss"></i> Subscribe</a>
    <a href="contact.php" class="w3-bar-item w3-button w3-padding-16"><i class="fa fa-envelope"></i> Contact</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <span class="w3-bar-item">Carlelo</span>
  <a href="javascript:void(0)" class="w3-right w3-bar-item w3-button" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:260px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:80px"></div>
<a href="mybooking.php"><h2 class="w3-text-blue" style="float: left"> Hi <?php echo $_SESSION['userData']['first_name']; ?></h2></a><h2 style="float:right; color: white;"><a href="login/logout.php">LOGOUT</a></h2>  <div class="w3-container">  
  <h2 class="w3-text-blue w3-light-grey"><?php echo $var1; ?></h2>
  <br>
  <?php echo $var;?>
  <br><br>
  <hr>
   <p class="w3-light-grey" style="float: right">Subscribe to receive updates on available special offers.</p>
    <p><button class="w3-button w3-blue w3-third" onclick="document.getElementById('subscribe').style.display='block'">Subscribe</button></p>
  </div>
  <hr>
  
  <footer class="w3-container w3-padding-16" style="margin-top:32px">By <a href="https://sites.google.com/ves.ac.in/apn/" class="w3-hover-text-blue w3-text-white">Ankit-Pratik-Nilesh</a></footer>

<!-- End page content -->
</div>

<!-- Subscribe Modal -->
<div id="subscribe" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom w3-padding-large">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('subscribe').style.display='none'" class="fa fa-remove w3-button w3-xlarge w3-right w3-transparent"></i>
      <h2 class="w3-wide">SUBSCRIBE</h2>
      <p>Join our mailing list to receive updates on special offers!</p>
      <form action="subscribe.php" method="post">
        <p><input class="w3-input w3-border" type="email" name="semail" placeholder="Enter e-mail"></p>
        <button class="w3-button w3-padding-large w3-blue w3-margin-bottom" type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</div>

<script>
// Script to open and close sidebar when on tablets and phones
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>