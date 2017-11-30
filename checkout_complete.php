<?php
include 'init.php';
if (isset($_SESSION["cart_array"])) {
	unset($_SESSION["cart_array"]);
}

?>
<head>
<title>Smart Store</title>
<?php include 'includes/head.php';?>
</head>
<body>
  <div class="wrap">
  <div class ="header">
  <?php include 'includes/header.php';?>
  
	</div>
	<div class="menu">
	  <?php include 'includes/menu.php';?>
	</div>
<div class="header_bottom">
		
 <div class="main">
    <div class="content">
    	<div class="register_account" style="margin-left:170px">
    		
		   <h3>Your payment was successful...Thank you for shopping.</h3>
			
    	</div>
       <div class="clear"></div>
    </div>
 </div>
</div>
	<div class="footer">
   	  <?php include 'includes/footer.php';?>
    </div>
</body>
</html>