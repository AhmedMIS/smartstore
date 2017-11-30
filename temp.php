<?php
include 'init.php';

function test_input($data) {
  $data = trim($data);
  $data = mysql_real_escape_string($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_GET['message']) && !empty($_GET['message'])) {
	$message = test_input($_GET['message']);
	//$message .= "Go back <a href=\"index.php\">Home</a>"; 
} else {
	header('Location: page_not_found.php');
	exit();	
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
    		
		   <h3><?php echo $message ?></h3>
			
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