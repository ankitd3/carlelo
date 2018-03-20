<?php
SESSION_start();
if(!isset($_SESSION['userData']))
  {
    header("location:login/index.php");
  }
$boo ="";
$future="";
$ongoing="";
$past="";
$futuree="";
$ongoingg="";
$pastt="";
$pic = '<img src="'.$_SESSION['userData']['picture'].'" width="210" height="220">';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carlelo";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set('Asia/Kolkata');
$current_datetime = date('Y-m-d H:i:s');
$troll=$_SESSION['userData']['email'];
$sql = "SELECT * FROM booking WHERE email='$troll' ORDER BY booikingtime DESC;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["drop_car"]<$current_datetime){
          $pastt="<h3 style=color:black>Past BOOKINGS:</h3>";
          $past .= "<h4 style=color:black>Booking ID: ".$row["Bid"]."</h4>CAR id: " . $row["car_id"]. " <br>PICK: " . $row["pickup"]. " <br>DROP:     " . $row["drop_car"]."<br>Amount Paid: Rs.".$row["amount"]. "/-<br>Booking TIME: ". $row["booikingtime"]."<br>";
        }
        elseif($row["pickup"]>$current_datetime){
          $futuree="<h3 style=color:black>Future BOOKINGS:</h3>";
          $future .= "<h4 style=color:black>Booking ID: ".$row["Bid"]."</h4>CAR id: " . $row["car_id"]. " <br>PICK: " . $row["pickup"]. " <br>DROP: " . $row["drop_car"]."<br>Amount Paid: Rs.".$row["amount"]. "/-<br>Booking TIME: ". $row["booikingtime"]."<br>";
        } 
        else{
          $ongoingg="<h3 style=color:black>Ongoing BOOKINGS:</h3>";
          $ongoing .= "<h4 style=color:black>Booking ID: ".$row["Bid"]."</h4>CAR id: " . $row["car_id"]. " <br>PICK: " . $row["pickup"]. " <br>DROP: " . $row["drop_car"]."<br>Amount Paid: Rs.".$row["amount"]. "/-<br>Booking TIME: ". $row["booikingtime"]."<br>";
        }
    }
}else {
    $boo = "0 results";
}
$past=$pastt.$past;
$future=$futuree.$future;
$ongoing=$ongoingg.$ongoing;
$conn->close();

?>
<!DOCTYPE html>
<html>
<title>MyBOOKINGS</title>
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
li{
  margin: 15px 0;
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
<a href="mybooking.php"><h2 class="w3-text-blue" style="float: left"> Hi <?php echo $_SESSION['userData']['first_name']; ?></h2></a><h2 style="float:right; color: white;"><a href="login/logout.php">LOGOUT</a></h2>

  <div align="center"><?php echo $pic; ?></div>

  <div class="w3-container">
    <h3 align="center" class="w3-text-blue w3-light-grey"><?php echo $boo;?></h3>
    <div align="center" class="w3-text-blue w3-light-grey"><?php echo $ongoing;?></div>
    <div align="center" class="w3-text-blue w3-light-grey"><?php echo $future;?></div>
    <div align="center" class="w3-text-blue w3-light-grey"><?php echo $past;?></div>
  
  <form action="cancel.php" method="post">
      <p align="center"><label><i class="fa fa-times"></i> CANCEL Booking (ENTER THE BOOKING ID HERE)</label></p>
      <input class="w3-input w3-border" type="timestamp" name="cancel" required>
      <p><button class="w3-button w3-block w3-blue w3-center-align" type="submit"><i class="fa w3-margin-right"></i> Cancel</button></p>
  </form>

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