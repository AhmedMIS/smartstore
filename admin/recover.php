<?php
include '../init.php';
if (isset($_GET['success']) && empty($_GET['success'])) {
	$errors[] = 'We have sent you mail.';
} else {
	$mode_allowed = array('username', 'password');
	if (isset($_GET['mode']) && in_array($_GET['mode'], $mode_allowed) === true) {
		if (isset($_POST['submit'])) {
			if (empty($_POST['email'])) {
				$errors[] = 'Enter your email.';
			} else {
				if (email_exists($_POST['email']) === false) {
					$errors[] = 'That email does not exist.';
				}	
			}
			
			if (empty($errors)) {
				recover($_GET['mode'], $_POST['email']);
				header('Location:recover.php?success');
				exit();
			} else {
		
			}
		}
	} else echo 'no';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Area</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body style="background-color:#333;">
	<div id="heading">
    	<h1>Smart Store</h1><p>Admin Login</p>
    </div>
    	
	<div id="login">
    <?php if (!empty($errors)) { foreach ($errors as $error) { echo '<p>'.$error.'</p>'; } }?>
        <ul>
        	<li>
            <form action="" method="POST">
            	Enter your email address:<br />
            	<input type="text" name="email" id="email" /><br />
                <input type="submit" name="submit" value="Recover" />
            </form>
            </li>
        </ul>

	</div>
</body>
</html>