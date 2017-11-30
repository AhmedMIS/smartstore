<?php include 'init.php';

function test_input($data) {
	$data = mysql_real_escape_string($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	$data = preg_split('/[\s]+/', $data);
	$data	= implode(" ",$data);
	return $data;
}

if (logged_in() === false && isset($_SESSION['pid'])) {
	$_SESSION['redirect'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header('Location:login.php');
	exit();
} else if (logged_in() === false && !isset($_SESSION['pid'])) {
	header('Location:page_not_found.php');
	exit();
} else if (logged_in() === true && !isset($_SESSION['pid'])) {
	header('Location:page_not_found.php');
	exit();
} 

$sql = mysql_query("SELECT email, contact FROM users WHERE user_id='$session_user_id'");
$productCount = @mysql_num_rows($sql);
if ($productCount > 0) {
	while ($row = mysql_fetch_array($sql)) {
		$email		= $row['email'];
		$contact	= $row['contact'];
	}
}
if (isset($_POST['submit'])) {
	if (empty(trim($_POST['email']))) {
		$errors[] = 'Email addess can not be empty.';
	} else {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$errors[] = 'A valid email address is required.';
		}
	}
	if (empty($_POST['number'])) {
		$errors[] = 'Mobile number can not be empty.';
	}
	if (empty($_POST['state'])) {
		$errors[] = 'Select a valid state.';
		echo '<style type="text/css">
        	#c select{
				border:1px solid red;
			}
        	</style>';
	}
	if (empty($_POST['city'])) {
		$errors[] = 'Select a valid city.';
		echo '<style type="text/css">
        	#d select{
				border:1px solid red;
			}
        	</style>';
	}
	if (empty(trim($_POST['street']))) {
		$errors[] = 'Street addess can not be empty.';
		echo '<style type="text/css">
        	#e input{
				border:1px solid red;
			}
        	</style>';
	} else $street = $_POST['street'];
	if (empty($errors)) {
		$email	= test_input($_POST['email']);
		$number	= $_POST['number'];
		$state	= $_POST['state'];
		$city	= $_POST['city'];
		$street	= test_input($_POST['street']);
		$zip	= $_POST['zip'];
		
		$continue_checkout = '<div style="border:1px solid #cbcbcb; padding:25px; width:573px"><h2>Delivery Address Confirmed.</h2><br><form method="POST" action=""><input type="hidden" name="hidden_email" value="'.$email.'"><input type="hidden" name="hidden_number" value="'.$number.'"><input type="hidden" name="hidden_state" value="'.$state.'"><input type="hidden" name="hidden_city" value="'.$city.'"><input type="hidden" name="hidden_street" value="'.$street.'"><input type="hidden" name="hidden_zip" value="'.$zip.'"><input type="submit" name="continue_checkout" value="Continue Checkout" style="padding:5px"></form></div>';
		
	}
}
if (isset($_POST['continue_checkout'])) {
	$sql	= mysql_query("SELECT first_name from users WHERE user_id='$session_user_id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while ($row = mysql_fetch_array($sql))
			$first_name = $row['first_name'];
	} else echo 'no';
	$product_id_array	= $_SESSION['pid'];
	$price				= $_SESSION['total'];
	$email				= $_POST['hidden_email'];
	$number				= $_POST['hidden_number'];
	$city				= $_POST['hidden_city'];
	$state				= $_POST['hidden_state'];
	$street				= $_POST['hidden_street'];
	$zip				= $_POST['hidden_zip'];
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < 17; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
	$sql = mysql_query("INSERT INTO `transactions`(`user_id`, `product_id_array`, `payer_email`, `first_name`, `txn_id`, `payment_status`, `address_street`, `address_city`, `address_state`, `address_country`, `payment_date`, `mc_gross`, `address_zip`, `payment_type`) VALUES ('$session_user_id', '$product_id_array', '$email', '$first_name', '$randomString', 'Pending', '".addslashes($street)."','$city','$state','Pakistan',now(),'$price','$zip','On Delivery')");
	if ($sql) {
		$insert = 'Your order has been confirmed.';
		$mail = mail('$email','Your order has been confirmed.','Your order id is'.$randomString);
		if ($mail) {
			echo 'ok';
		} else echo 'no';
		unset($_SESSION['pid']);
		unset($_SESSION['cart_array']);
		header('Location:temp.php?message='.$insert);
		exit();
	} else {
		$insert = 'Something went wrong. Try again later.';
		header('Location:temp.php?message='.$insert);
		exit();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Smart Store</title>
<?php include 'includes/head.php';?>
<script>
function populate(s1,s2){
	var s1 = document.getElementById(s1);
	var s2 = document.getElementById(s2);
	s2.innerHTML = "";
	if(s1.value == "Punjab"){
		var optionArray = ["|","Attock|Attock","Bahawal nagar|Bahawal nagar","Bahawalpur|Bahawalpur","Bhakkar|Bhakkar","Chakwal|Chakwal","Dera Ghazi Khan|Dera Ghazi Khan","Faisalabad|Faisalabad","Gujjar Khan|Gujjar Khan","Gujranwala|Gujranwala","Gujrat|Gujrat","Hafizabad|Hafizabad","Jhang|Jhang","Jehlum|Jehlum","Kahuta|Kahuta","Kasur|Kasur","Khanewal|Khanewal","Khushab|Khushab","Lahore|Lahore","Layyah|Layyah","Mandi Bahauddin|Mandi Bahauddin","Mianwali|Mianwali","Multan|Multan","Murree|Murree","Muzaffargarh|Muzaffargarh","Okara|Okara","Rahimyar Khan|Rahimyar Khan","Rawalpindi|Rawalpindi","Sahiwal|Sahiwal","Sargodha|Sargodha","Sialkot|Sialkot"];
	} else if(s1.value == "Sindh"){
		var optionArray = ["|","Daddu|Daddu","Hyderabad|Hyderabad","Jacobabad|Jacobabad","Karachi Alhydri|Karachi Alhydri","Karachi city|Karachi city","Karachi|Karachi","Karachi Saddar|Karachi Saddar","Khair Pur|Khair Pur","Korangi|Korangi","Larkana|Larkana","Mirpur Khas|Mirpur Khas","Nawabshah|Nawabshah","Sanghar|Sanghar","Shikarpur|Shikarpur","Sukkur|Sukkur"];
	} else if(s1.value == "Khyber-Pakhtunkhwa"){
		var optionArray = ["|","Abbottabad|Abbottabad","Bannu|Bannu","Batkhela|Batkhela","Charsadda|Charsadda","Chitral|Chitral","Dera Ismail Khan|Dera Ismail Khan","Haripur|Haripur","Karak|Karak","Kohat|Kohat","Lakki Marwat|Lakki Marwat","Mansehra|Mansehra","Mardan|Mardan","Nowshera|Nowshera","Peshawar|Peshawar","Saidu Sharif|Saidu Sharif"];
	} else if(s1.value == "Balochistan"){
		var optionArray = ["|","Quetta|Quetta","Sibbi|Sibbi","Loralai|Loralai"];
	} else if(s1.value == "Attock"){
		var num = '43600'; document.getElementById("zip").value=num;
	} else if(s1.value == "Bahawal nagar"){
		var num = '62300'; document.getElementById("zip").value=num;
	} else if(s1.value == "Bhakkar"){
		var num = '30000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Chakwal"){
		var num = '48800'; document.getElementById("zip").value=num;
	} else if(s1.value == "Dera Ghazi Khan"){
		var num = '32200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Faisalabad"){
		var num = '38000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Gujjar Khan"){
		var num = '47850'; document.getElementById("zip").value=num;
	} else if(s1.value == "Gujranwala"){
		var num = '52250'; document.getElementById("zip").value=num;
	} else if(s1.value == "Gujrat"){
		var num = '50700'; document.getElementById("zip").value=num;
	} else if(s1.value == "Hafizabad"){
		var num = '52110'; document.getElementById("zip").value=num;
	} else if(s1.value == "Jhang"){
		var num = '35200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Jehlum"){
		var num = '49600'; document.getElementById("zip").value=num;
	} else if(s1.value == "Kahuta"){
		var num = '47330'; document.getElementById("zip").value=num;
	} else if(s1.value == "Kasur"){
		var num = '55050'; document.getElementById("zip").value=num;
	} else if(s1.value == "Khanewal"){
		var num = '58150'; document.getElementById("zip").value=num;
	} else if(s1.value == "Khushab"){
		var num = '41000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Lahore"){
		var num = '54000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Layyah"){
		var num = '31200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Mandi Bahauddin"){
		var num = '50400'; document.getElementById("zip").value=num;
	} else if(s1.value == "Mianwali"){
		var num = '42200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Multan"){
		var num = '60000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Murree"){
		var num = '47150'; document.getElementById("zip").value=num;
	} else if(s1.value == "Muzaffargarh"){
		var num = '34200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Okara"){
		var num = '56300'; document.getElementById("zip").value=num;
	} else if(s1.value == "Rahimyar Khan"){
		var num = '64200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Rawalpindi"){
		var num = '46000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sahiwal"){
		var num = '57000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sargodha"){
		var num = '40100'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sialkot"){
		var num = '51310'; document.getElementById("zip").value=num;
	} else if(s1.value == "Daddu"){
		var num = '76200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Hyderabad"){
		var num = '71000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Jacobabad"){
		var num = '79000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Karachi Alhydri"){
		var num = '74700'; document.getElementById("zip").value=num;
	} else if(s1.value == "Karachi city"){
		var num = '74000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Karachi"){
		var num = '74200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Karachi Saddar"){
		var num = '74400'; document.getElementById("zip").value=num;
	} else if(s1.value == "Khair Pur"){
		var num = '66020'; document.getElementById("zip").value=num;
	} else if(s1.value == "Korangi"){
		var num = '74900'; document.getElementById("zip").value=num;
	} else if(s1.value == "Larkana"){
		var num = '77150'; document.getElementById("zip").value=num;
	} else if(s1.value == "Mirpur Khas"){
		var num = '69000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Nawabshah"){
		var num = '67450'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sanghar"){
		var num = '68100'; document.getElementById("zip").value=num;
	} else if(s1.value == "Shikarpur"){
		var num = '78100'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sukkur"){
		var num = '65200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Abbottabad"){
		var num = '22010'; document.getElementById("zip").value=num;
	} else if(s1.value == "Bannu"){
		var num = '28100'; document.getElementById("zip").value=num;
	} else if(s1.value == "Batkhela"){
		var num = '23020'; document.getElementById("zip").value=num;
	} else if(s1.value == "Charsadda"){
		var num = '24420'; document.getElementById("zip").value=num;
	} else if(s1.value == "Chitral"){
		var num = '17200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Dera Ismail Khan"){
		var num = '29050'; document.getElementById("zip").value=num;
	} else if(s1.value == "Haripur"){
		var num = '22620'; document.getElementById("zip").value=num;
	} else if(s1.value == "Karak"){
		var num = '27200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Kohat"){
		var num = '26000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Lakki Marwat"){
		var num = '28420'; document.getElementById("zip").value=num;
	} else if(s1.value == "Mansehra"){
		var num = '21300'; document.getElementById("zip").value=num;
	} else if(s1.value == "Mardan"){
		var num = '23200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Nowshera"){
		var num = '24100'; document.getElementById("zip").value=num;
	} else if(s1.value == "Peshawar"){
		var num = '25000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Saidu Sharif"){
		var num = '19200'; document.getElementById("zip").value=num;
	} else if(s1.value == "Quetta"){
		var num = '87300'; document.getElementById("zip").value=num;
	} else if(s1.value == "Sibbi"){
		var num = '82000'; document.getElementById("zip").value=num;
	} else if(s1.value == "Loralai"){
		var num = '84800'; document.getElementById("zip").value=num;
	}
	
	for(var option in optionArray){
		var pair = optionArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		s2.options.add(newOption);
	}
}
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }


</script>
</head>
<body>
<div class="wrap">
	<div class="header">
		<?php include 'includes/header.php'; ?>
	</div>
	<div class="menu">
	  <?php include 'includes/menu.php'; ?>
	</div>
<div class="header_bottom">	
	<div class="main">
		<div class="content">
       	  <div id="cash_on">
           	<h2>Delivery Address:</h2>
            <p style="color:red;"><?php if (!empty($errors)) foreach($errors as $error) echo $error.'<br>';?></p>
              <table width="53%" border="1">
              	<form action="" method="POST">
                <tr>
                  <td width="28%">Email:</td>
                  <td width="72%"><div id="a"><input type="text" name="email" id="email" value="<?php echo $email ?>" /></div></td>
                </tr>
                <tr>
                  <td width="28%">Mobile Number:</td>
                  <td width="72%"><div id="b"><input type="text" name="number" id="number" value="<?php echo $contact ?>" maxlength="11" onkeypress="return isNumberKey(event)" /></div></td>
                </tr>
                <tr>
                  <td>State:</td>
                  <td><div id="c">
                  	<select name="state" id="state" onchange="populate(this.id,'city')">
                    	<option></option>
                  		<option>Punjab</option>
                        <option>Khyber-Pakhtunkhwa</option>
                        <option>Balochistan</option>
                        <option>Sindh</option>
                    </select></div></td>
                </tr>
                <tr>
                  <td>City:</td>
                  <td><div id="d">
                  	<select name="city" id="city" onchange="populate(this.id,'zip')">
                    	<option></option>
                    </select></div></td>
                </tr>
                <tr>
                  <td>Address Street:</td>
                  <td><div id="e"><input type="text" name="street" id="street" size="50" value="<?php if(!empty($street)) echo $street ?>" /></div></td>
                </tr>
                <tr>
                  <td>Zip Code:</td>
                  <td><input type="text" name="zip" id="zip" readonly="readonly" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="submit" value="Submit" style="padding:5px" /></td>
                </tr>
                </form>
              </table>
                <?php if (isset($continue_checkout)) echo $continue_checkout?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="footer">
   	  <?php include 'includes/footer.php'; ?>
    </div>
</div>
</div>
</body>
</html>

