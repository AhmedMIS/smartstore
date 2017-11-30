<?php
include 'head.php';
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
</head>
<body>
	<div id="wrapper">
    <?php include 'header.php' ?>
		<div id="login">
			<h1>Existing Customers</h1>
            <?php if (!empty($errors)) foreach($errors as $error) echo '<p>&#9658 '.$error.'</p>'?>
        	<form action="" method="POST">
                <table>
                  <tr>
                    <td><h2>Username:</h2></td>
                    <td><input name="username" type="text" class="field" value="<?php if(isset($username)) echo $username?>"></td>
                  </tr>
                  <tr>
                    <td><h2>Password:</h2></td>
                    <td><input name="password" type="password" class="field"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><div class="buttons"><div><button class="grey" type="submit" name="submit">Sign In</button></div></div></td>
                  </tr>
                </table>
			</form>
		</div>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>
	</div>
</body>
</html>

