<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; 
if (logged_in() === false) {
	$_SESSION['redirect'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header('Location: login.php');
	exit();
}?>
</head>

<body>
	<div id="wrapper">
    	<?php include 'header.php'; include 'post_ad.php'; ?>
    	<div id="footer">
    		<?php include 'footer.php' ?>
    	</div>
    </div>
</body>
</html>
