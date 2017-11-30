<?php
include '../init.php';
if (logged_admin() === true) {
	header('Location: index.php');
	exit();
}

if (isset($_POST['submit'])) {
	if (empty($_POST['username'])) {
		$errors[] = 'Enter a username.';
		echo '<style type="text/css">
        #username{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($_POST['password'])) {
		$errors[] = 'Enter a password.';
		echo '<style type="text/css">
        #password{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($errors)) {
		$username	= $_POST['username'];
		$password	= $_POST['password'];
		if (admin_exists($username) === false) {
			$errors[] = 'That username does not exist.';
		} else {
			$login = log_admin($username, $password);
			if ($login === false) {
				$errors[] = 'Incorrect password.';
			} else {
				$_SESSION['admin_id'] = $login;
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Area</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body style="background-color:#ccc;">
	<div id="heading">
    	<h1>Smart Store</h1><p>Admin Login</p>
    </div>
    	
	<div id="login">
    <?php if (!empty($errors)) { foreach ($errors as $error) { echo '<p>&#9658 '.$error.'</p>'; } }?>
    	<table width="100%" border="1">
        <form action="" method="POST">
          <tr>
            <td>Username:</td>
            <td><input type="text" name="username" id="username" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input type="password" name="password" id="password" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="submit" value="Login" />
            <!--<a href="recover.php?mode=username">Forgot username?</a><br /><a href="recover.php?mode=password">Forgot password?</a>--></td>
          </tr>
          </form>
        </table>

	</div>
</body>
</html>