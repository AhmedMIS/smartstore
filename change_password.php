<h2>Change Password:</h2><br />
<?php
function get_old_password($user_id) {
	$sql = mysql_query("SELECT password from users WHERE user_id='$user_id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$password = $row["password"];
		}
	} else {
		return false;
	}
	return $password;
}

if (isset($_POST['submit'])) {
	if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['again_password'])) {
		$errors[] = 'Fill all three fields to continue.';
	} else {
		if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['again_password'])) {
			if (trim($_POST['new_password']) !== trim($_POST['again_password'])) {
				$errors[] = 'Your new passwords do not match.';
			}
			$password = get_old_password($session_user_id);
			if ($password !== md5($_POST['old_password'])) {
				$errors[] = 'Your old password was incorrect.';
			}
		}
	}
	if (empty($errors)) {
		change_password($session_user_id, trim($_POST['new_password']));
		echo '<p style="color:blue;font-weight:bold;border:1px solid #cecece;padding:10px;">Password was successfully changed.</p>';
	} else {
		foreach ($errors as $error) {
			echo '<p style="color:red">'.$error.'</p>';
		}
	}
}


?>

<form action="" method="POST">
    <table width="100%" border="1">
      <tr>
        <td width="30%"><h1>Old Password</h1></td>
        <td><input type="password" name="old_password" maxlength="15"></td>
      </tr>
      <tr>
        <td><h1>New Password:</h1></td>
        <td><input type="password" name="new_password" maxlength="15"><p>(Maximum 15 characters)</p></td>
      </tr>
      <tr>
        <td><h1>Confirm New Password:</h1></td>
        <td><input type="password" name="again_password" maxlength="15"><p>(Maximum 15 characters)</p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit"></td>
      </tr>
    </table>
</form>