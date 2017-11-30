<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php';

if (!isset($_GET['id']) || empty($_GET['id']) || exists_id($_GET['id']) === false) {
	header('Location:page_not_found.php');
	exit();
} else {
	$id			= mysql_real_escape_string(htmlentities(trim($_GET['id'])));
	list($title, $description, $price, $brand, $date, $user_id, $city, $category, $subcategory) = show_ad($id);
	$user_data = user_data($user_id, 'first_name', 'email', 'contact');
}

if (isset($_POST['submit'])) {
	if (!empty($_POST['pmSubject']) && !empty($_POST['pmMessage'])) {
		$subject	= test_input($_POST['pmSubject']); $subject = implode(" ", $subject);
		$message	= test_input($_POST['pmMessage']); $message = implode(" ", $message);
		$sender		= $_POST['pm_sender_id'];
		$receiver	= $_POST['pm_rec_id'];
		$sql = mysql_query("INSERT INTO `private_messages`(`to_id`, `from_id`, `time_sent`, `subject`, `message`, `opened`, `recipientDelete`, `senderDelete`) VALUES ('$receiver','$sender',current_timestamp(),'$subject','$message','0','0','0')");
		if ($sql) {
			$result = 'success';
		} else {
			$result = 'fail';
		}
	} else {
		$pm = 'Enter a subject and message.';
	}
}
?>
</head>
<body>
	<div id="wrapper">
		<?php include 'header.php' ?>
        <div class="top_links">
        <table width="100%" style="border-bottom:2px solid #cbcbcb">
          <tr>
            <td><h2><a href="categories.php">All Categories</a> → <a href="results.php?search=<?php echo urlencode($category) ?>"><?php echo $category ?></a> → <a href="results.php?search=<?php echo urlencode($subcategory) ?>"><?php echo $subcategory ?></a></h2></td>
            <td align="center"><h2><?php echo "<a href=\"javascript:history.go(-1)\">Back</a>"; ?></h2></td>
          </tr>
        </table>
        </div>
        <div class="show_ad" style="width:55%; float:left;">
        	<h2><?php echo $title ?></h2>
            <p><?php echo date("M j, Y",strtotime($date)) ?></p>
            <div id="banner-slide">
                <!-- start Basic Jquery Slider -->
                <ul class="bjqs">
                  <li><img src="../admin/inventory_images/ads/<?php echo $user_id ?>/<?php echo $id ?>/<?php echo $id ?>.jpg" style="margin:0; min-width:150px; min-height:150px;" ></li>
                  <li><img src="../admin/inventory_images/ads/<?php echo $user_id ?>/<?php echo $id ?>/<?php echo $id ?>_1.jpg"style="margin:0; min-width:150px; min-height:150px;" ></li>
                  <li><img src="../admin/inventory_images/ads/<?php echo $user_id ?>/<?php echo $id ?>/<?php echo $id ?>_2.jpg"style="margin:0; min-width:150px; min-height:150px;" ></li>
                </ul>
                <!-- end Basic jQuery Slider -->
			</div>
            <div class="description">
            <table>
				<tr>
					<td><h2>Brand</h2></td>
					<td style="border-right:none"><?php echo $brand ?></td>
				</tr>
				<tr>
					<td><h2>Description</h2></td>
					<td style="border-right:none"><?php echo $description ?></td>
				</tr>
				<tr>
					<td><h2>Price:</h2></td>
					<td style="border-right:none">Rs. <?php echo $price ?></td>
				</tr>
			</table>
            </div>
        </div>
        <div class="show_ad" style="width:40%; float:right;">
        	<div class="description">
        	<h1>Seller details:</h1>
			<table>
				<tr>
					<td><h2>Name:</h2></td>
					<td width="300" style="border-right:none"><?php echo $user_data['first_name'] ?></td>
				</tr>
				<tr>
					<td><h2>Email:</h2></td>
					<td style="border-right:none"><?php echo $user_data['email'] ?></td>
				</tr>
				<tr>
					<td><h2>City:</h2></td>
					<td style="border-right:none"><?php echo $city ?></td>
				</tr>
				<tr>
					<td><h2>Contact:</h2></td>
					<td style="border-right:none"><?php echo $user_data['contact'] ?></td>
				</tr>
			</table>
            </div><br /><br />
            <?php 
			if (logged_in() === false) {
				$_SESSION['redirect'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				echo '<a href="login.php">[Login</a> to send a private message to ' .$user_data['first_name'].']';
			} else {
				if (!empty($result) && $result == 'success') {
					echo 'Your message was successfully sent.';
				} else if (!empty($result) && $result == 'fail') {
					echo 'Something went wrong. Try again.';
				} else if ($session_user_id == $user_id) {
					//echo 'Your ad.';
				} else {?>
                <div class="description">
			<h2>Send a private message to <?php echo $user_data['first_name'] ?></h2>
			<p><?php if (isset($pm)) echo $pm ?></p>
			<form action="" name="pmForm" id="pmForm" method="POST">
				<table>
					<tr>
						<td><h2>Subject:</h2></td>
						<td style="border-right:none"><input name="pmSubject" id="pmSubject" type="text" maxlength="64" width="98%" /></td>
					</tr>
					<tr>
						<td valign="top"><h2>Message:</h2></td>
						<td width="300" style="border-right:none"><textarea name="pmMessage" id="pmMessage" rows="8" cols="35" width="98%" onkeypress="if (this.value.length > 300) { return false; }"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="border-right:none"><input name="submit" type="submit" value="Submit" /></td>
					</tr>
				</table></div>
				<input name="pm_sender_id" id="pm_sender_id" type="hidden" value="<?php echo $session_user_id ?>" />
				<input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $user_id ?>" />
			</form>
	<?php
				}
			}?>
            
        </div>
        <div class="clear"></div>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>
	</div>
</body>
</html>
