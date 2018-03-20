<?php
SESSION_start();
if(!isset($_SESSION['userData']))
  {
    header("location:login/index.php");
  }
?>
<!DOCTYPE html>
<html>
<title>rules</title>
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
<a href="mybooking.php"><h2 class="w3-text-blue" style="float: left"> Hi <?php echo $_SESSION['userData']['first_name']; ?></h2></a><h2 style="float:right; color: white;"><a href="login/logout.php">LOGOUT</a></h2>
  <div class="w3-container">
    
  <h2 class="w3-text-blue"><strong>About US</strong></h2>
    <p class="w3-light-grey">From planning a trip outside the city to moving around inside one, a new era of freedom is here with Carlelo – Mumubai’s premier self-drive car rental. So, for your next trip to sunny beaches, or to the mall for shopping or movies, hire a car from Carlelo anytime you want it. Carlelo provides you with the wheels to drive around at a short notice, while also offering a range of luxury car hire options to choose from. With all India permit for every car, you are set to drive out as far as you want to go!</p>
<p class="w3-light-grey">
You can rent a self-drive car from Carlelo without worries, as all vehicles are covered under damage insurance along with 24x7 roadside assistance. Carlelo brings it all to your fingertips, with a very convenient booking process that takes only a few minutes on the website.</p>
<p class="w3-light-grey">
With cars in India multiplying by the day, the costs of owning one have gone beyond just the initial financials! Periodic depreciation in value, high maintenance costs, rising fuel prices, parking space shortages in cities, etc. add a hefty premium to the overall cost of ownership. Carlelo’s vehicles offer you with a ‘self-drive car rental’ solution- one in which you’re in the driving seat, literally.</p>
    <p>We accept: <i class="fa fa-credit-card w3-large"></i> <i class="fa fa-cc-mastercard w3-large"></i> <i class="fa fa-cc-amex w3-large"></i> <i class="fa fa-cc-cc-visa w3-large"></i><i class="fa fa-cc-paypal w3-large"></i></p>
    <hr></p>
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