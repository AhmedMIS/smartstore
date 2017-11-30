<?php
include 'init.php';
if (logged_in() === true) {
	header('Location: index.php');
	exit();
}
function test_input($data) {
  $data = trim($data);
  $data = mysql_real_escape_string($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  $data = preg_split('/[\s]+/', $data);
  $data	= implode(" ",$data);
  return $data;
}

if (empty($_POST) === false) {
	$username		= test_input($_POST['username']);
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
		$message = 'Thank you for registering.';
		header('Location:temp.php?message=' . $message);
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
		<div class ="header">
			<?php include 'includes/header.php';?>
		</div>
		<div class="menu">
			<?php include 'includes/menu.php';?>
		</div>
       
    	<div class="register_account">
    		<h3>Register New Account</h3>
			<?php if (!empty($errors)) foreach($errors as $error)echo '<p>&#9658 '.$error.'</p>' ?>
    		<form action="" method="post">
            <table width="100%" border="1">
              <tr>
                <td>Email:</td>
                <td><input type="text" name="email" maxlength="35" value="<?php if (isset($email)) echo $email; ?>"></td>
              </tr>
              <tr>
                <td>Username:</td>
                <td><input name="username" type="text" maxlength="15" class="field" value="<?php if (isset($username)) echo $username; ?>"></td>
              </tr>
              <tr>
                <td>Password:</td>
                <td><input name="password" type="password" maxlength="15" class="field"><p>(6-15 characters)</p></td>
              </tr>
              <tr>
                <td>Confirm Password:</td>
                <td><input name="password_again" type="password" maxlength="15" class="field"><p>(6-15 characters)</p></td>
              </tr>
              <tr>
              <td></td>
              <td><div class="search"><button type="submit" name="submit" class="grey">Create Account</button></div></td>
              </tr>
            </table>				
           </form>
    	</div>
		<div class="clear"></div>
		<div class="footer">
			<?php include 'includes/footer.php';?>
		</div>
</body>
</html>

