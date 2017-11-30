<?php
include 'init.php';

if(logged_in() === true){
	header('Location: index.php');
	exit();
}

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'You need to enter a username and password.';
	} else if (user_exists($username) === false) {
		$errors[] = 'Username is not registered.';
	} else if (user_active($username) === false) {
		$errors[] = 'You have not activated your account.';
	} else {
		$login = login($username, $password);
		if ($login === false) {
			$errors[] = 'Username/password combination is incorrect.';
		} else {
			$_SESSION['user_id'] = $login;
			if (isset($_SESSION['redirect'])) {
				//echo $_SESSION['redirect'];
				header("Location: ".$_SESSION['redirect']);
				exit();
			} else {
				header('Location: index.php');
				exit();
			}
		}
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
			<h3>Existing Customers</h3>
            <?php if (!empty($errors)) foreach($errors as $error) echo '<p>&#9658 '.$error.'</p>'?>
        	<form action="" method="POST">
                <table width="100%" border="1">
                  <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text" class="field" value="<?php if(isset($username)) echo $username?>"></td>
                  </tr>
                  <tr>
                    <td>Password:</td>
                    <td><input name="password" type="password" class="field"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><div class="buttons"><div><button class="grey" type="submit" name="submit">Sign In</button></div></div></td>
                  </tr>
                </table><!--
				<p class="note">Forgot Username click <a href="recover.php?mode=username">here</a></p>
                <p class="note">Forgot Password click <a href="recover.php?mode=password">here</a></p>-->
			</form>
		</div>
		<div class="clear"></div>
		<div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>

