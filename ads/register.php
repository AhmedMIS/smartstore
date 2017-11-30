<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php';
if (logged_in() === true) {
	header('Location: index.php');
	exit();
}

if (empty($_POST) === false) {
	$username		= test_input($_POST['username']); $username = implode(" ", $username);
	$email			= $_POST['email'];
	$password		= strip_tags($_POST['password']);
	$password_again	= strip_tags($_POST['password_again']);
	if (empty($username) === true || empty($password_again) === true || empty($password) === true || empty($email) === true) {
		$errors[] =  'All fields are required to create account.';
	} else {
		if (email_exists($email) === true) {
			$errors[] = 'The email \'' . $email . '\' is already in use.';
		}
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'A valid email address is required.';
		}
		if (user_exists($username) === true) {
			$errors[] = 'The username \'' . $username . '\' is already taken.';
		}
		if (strlen($username) < 6) {
			$errors[] = 'Username must be atleast 6 characters.';
		}
		if (preg_match("/\\s/", $username) == true) {
			$errors[] = 'Username must not have spaces';
		} else {
			if (!preg_match("/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/", $username)) {
				$errors[] = 'Username must start with letter optional(digits or underscore).';
			}
		}
		if (strlen($password) < 6) {
			$errors[] = 'Password must be 6 - 15 characters.';
		} else {
			if ($password !== $password_again) {
				$errors[] = 'Passwords do not match.';
			}
		}
	}

	if (empty($errors) === true) {
		$register_data = array(
			'username'		=> $_POST['username'],
			'password'		=> $_POST['password'],
			'email'			=> $_POST['email'],
			'email_code'	=> md5($_POST['username'] + microtime())
		);
		
		register_user($register_data);
		$message = 'Thank you for registering.... check your email address to activate your account.';
		header('Location:temp.php?message=' . $message);
		exit();
	}	
}
?>
</head>
<body>
	<div id="wrapper">
		<?php include 'header.php';?>
        <div id="login">
    		<h1>Register New Account</h1>
			<?php if (!empty($errors)) foreach($errors as $error)echo '<p>&#9658 '.$error.'</p>' ?>
    		<form action="" method="post">
            <table>
              <tr>
                <td><h2>Email:</h2></td>
                <td><input type="text" name="email" maxlength="35" value="<?php if (isset($email)) echo $email; ?>"></td>
              </tr>
              <tr>
                <td><h2>Username:</h2></td>
                <td><input name="username" type="text" maxlength="15" class="field" value="<?php if (isset($username)) echo $username; ?>"></td>
              </tr>
              <tr>
                <td><h2>Password:</h2></td>
                <td><input name="password" type="password" maxlength="15" class="field"><p>(6-15 characters)</p></td>
              </tr>
              <tr>
                <td><h2>Confirm Password:</h2></td>
                <td><input name="password_again" type="password" maxlength="15" class="field"><p>(6-15 characters)</p></td>
              </tr>
              <tr>
              <td></td>
              <td><div class="search"><button type="submit" name="submit" class="grey">Create Account</button></div></td>
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

