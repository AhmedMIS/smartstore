<h2>Personal Information:</h2><br />
<?php

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	$data = preg_split('/[\s]+/', $data);
	$data	= implode(" ",$data);
	return $data;
}

$sql = mysql_query("SELECT first_name,contact,city FROM users WHERE user_id='$session_user_id'");
$productCount = @mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){
		$first_name	= $row["first_name"];
		$contact	= $row["contact"];
		$city		= $row["city"];
		}
} else {
	echo 'no';
}
if (isset($_POST['submit'])) {
	if (empty($_POST['first_name'])) {
		$errors[] = 'Enter a first name.';
	}
	if (empty($_POST['contact'])) {
		$errors[] = 'Enter a contact number.';
	}
	if (empty($_POST['city'])) {
		$errors[] = 'Enter a city.';
	}

	if (empty($errors)) {
		$first_name	= test_input($_POST['first_name']);
		$city		= test_input($_POST['city']);
		$contact	= $_POST['contact'];
		
		$update = mysql_query("UPDATE users SET first_name='".addslashes($first_name)."',contact='$contact',city='".addslashes($city)."' WHERE user_id='$session_user_id'");
		if ($update) {
			echo '<p style="color:blue;font-weight:bold;border:1px solid #cecece;padding:10px;">Personal Information updated.</p>';
		} else {
			echo 'Something went wrong';
		}
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
    <td><h1>First name:</h1></td>
    <td><input type="text" name="first_name" maxlength="15" value="<?php echo $first_name ?>"></td>
  </tr>
  <tr>
    <td><h1>Contact:</h1></td>
    <td><input type="text" name="contact" value="<?php echo $contact ?>" maxlength="11" onkeypress="return isNumberKey(event)"></td>
  </tr>
  <tr>
    <td><h1>City:</h1></td>
    <td><input type="text" name="city" maxlength="15"  value="<?php echo $city ?>"></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" name="submit" value="Submit"></td>
  </tr>
</table>
</form>
<SCRIPT language=Javascript>
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</SCRIPT>