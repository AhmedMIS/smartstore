<?php
include 'init.php';

if(logged_in() === true){
	header('Location: index.php');
	exit();
}
$mode_allowed = array('username', 'password');

if (!isset($_GET['mode']) || empty($_GET['mode'])) {
	header('Location: page_not_found.php');
	exit();
} else {
	if (isset($_GET['mode']) && in_array($_GET['mode'], $mode_allowed)) {
		if (isset($_POST['submit'])) {
			if (empty($_POST['email'])) {
				$errors[] = 'Enter an email address.';
			} else {
				if (email_exists($_POST['email']) === false) {
					$errors[] = 'That email does not exist.';
				}
			}
			if (empty($errors)) {
				recover_user($_GET['mode'], $_POST['email']);
				$message = 'Thanks we have emailed you at '. $_POST['email'];
				header('Location: temp.php?message='.$message);
				exit();
			}
		}
	} else {
		header('Location: page_not_found.php');
		exit();
	}
}


?>
<head>
<title>Smart Store</title>
<?php include 'includes/head.php';?>

</head>
<body>
	<div class="wrap">
		<div class="header">
			<?php include 'includes/header.php'; ?>
		</div>
		<div class="menu">
			<?php include 'includes/menu.php'; ?>
		</div>
		<div class="login_panel">
			<h3>Recover <?php echo $_GET['mode']; ?></h3>
            <?php if (!empty($errors)) foreach($errors as $error) echo '<p>&#9658 '.$error.'</p>'; ?>
        	<form action="" method="POST">
            	<label>Enter your email address:</label><br>
				<input name="email" type="text" class="field">
				<div class="buttons"><div><button class="grey" type="submit" name="submit">Recover</button></div></div>
			</form>
		</div>
		<div class="clear"></div>
		<div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>

