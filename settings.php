<?php

include 'init.php';

if (logged_in() === false) {
	header("Location:index.php");
	exit();
}

 if (empty($_POST) === false) {
		if (empty($_POST['current_password']) || empty($_POST['password']) || empty($_POST['password_again'])) {
			$errors[] = "All fields are required.";
			//print_r($errors);
		} else if (md5($_POST['current_password']) === $user_data['password']) {
			if (trim($_POST['password']) === trim($_POST['password_again'])) {
				if (strlen($_POST['password']) < 6) {
					$errors[] = 'Password must be atleast 6 characters.';
				} else if (strlen($_POST['password']) >= 6) {
					change_password($session_user_id, $_POST['password']);
					header('Location: settings.php?success');
				}
			} else{
				$errors[] = 'Your new passwords do not match.';
			}
		} else if (md5($_POST['current_password']) !== $user_data['password']) {
			$errors[] = 'Your current password is incorrect.';
		}
	}
	
if (isset($_GET['success']) && empty($_GET['success'])) {
	echo 'Your password has been updated!';

} else{
	if (empty($errors) === true) {
		
	} else if (empty($errors) === false) {
		echo output_errors($errors);
	}

?> 
<h1>Change password</h1>

<form action="" method="post">
	<ul>
		<li>
			Current password:<br>
			<input type="text" name="current_password">
		</li>
		<li>
			New password:<br>
			<input type="text" name="password">
		</li>
		<li>
			Confirm password:<br>
			<input type="text" name="password_again">
		</li>
		<li>
			<input type="submit" value="submit">
		</li>
	</ul>
</form>
<?php }?>