<?php include 'init.php';

if (logged_in() === false) {
	$_SESSION['redirect'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	header('Location:login.php');
	exit();
}

function exists_id($id) {
	$sql = mysql_query("SELECT id FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

function get_name($id) {
	$sql = mysql_query("SELECT product_name FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql))
		$product_name = $row['product_name'];
		return $product_name;
	} else {
		echo 'no';
		return false;
	}
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
	header('Location:page_not_found.php');
	exit();
} else {
	if (exists_id($_GET['id']) === false) {
		header('Location:page_not_found.php');
		exit();
	}
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if (preg_replace('#[^A-Za-z]#i', '', $_GET['id'])) {
    		header('Location:page_not_found.php');
			exit();
		}
		$product_name = get_name($_GET['id']);
		$id	= mysql_real_escape_string(htmlentities(trim($_GET['id'])));
	}
}

$sql = mysql_query("SELECT id FROM product_review WHERE user_id=$session_user_id AND product_id=$id");
$productCount = @mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	$message = 'You have already reviewed this product.';
	header('Location: temp.php?message=' . $message);
	exit();
}


function test_input($data) {
	$data = mysql_real_escape_string($data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	$data = preg_split('/[\s]+/', $data);
	return $data;
}

if (isset($_POST['submit'])) {
	$title	= test_input($_POST['title']);
	$title	= implode(" ",$title);
	$review	= test_input($_POST['review']);
	$review	= implode(" ",$review);
	if (isset($_POST['rating'])) {
		$rating = $_POST['rating'];
		if ($rating == 1) $status1 = 'checked';
		else if($rating == 2) $status2 = 'checked';
		else if($rating == 3) $status3 = 'checked';
		else if($rating == 4) $status4 = 'checked';
		else if($rating == 5) $status5 = 'checked';
	}
	if (empty($title)) {
		$errors[] = 'Review Title can not be empty.<br>';
		echo '<style type="text/css">
        .nothing table td input{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($review)) {
		$errors[] = 'Your Review can not be empty.<br>';
		echo '<style type="text/css">
        .nothing table td textarea{
			border:1px solid red;
		}
        </style>';
	}
	if (!isset($_POST['rating'])) {
		$errors[] = 'Rating can not be empty.';
		echo '<style type="text/css">
        .nothing table td rating{
			border:1px solid red;
		}
        </style>';
	}
	if (!empty($_POST['title']) && !empty($_POST['review']) && isset($_POST['rating'])) {
		$title	= test_input($_POST['title']);
		$title	= implode(" ",$title);
		$review	= test_input($_POST['review']);
		$review	= implode(" ",$review);
		$rating	= $_POST['rating'];
		
		$sql = mysql_query("INSERT INTO `product_review` (`user_id`,`product_id`,`title`,`review`,`rating`,`date_added`) VALUES ('$session_user_id','$id','".addslashes($title)."','".addslashes($review)."','$rating',now())");
		
		$message = 'Thank you for reviewing our product.';
		header('Location:temp.php?message=' . $message);
		exit();
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Smart Store</title>
	<?php include 'includes/head.php';?>
</head>
<body>
	<div class="wrap">
    	<div class="header">
			<?php include 'includes/header.php'; ?>
            <div class="menu">
				<?php include 'includes/menu.php'; ?>
			</div>
                <div class="header_bottom">
                </div><div class="clear"></div>
				<div class="main">
					<div class="content">
                    	<div class="left_side" style="width:350px; height:auto;">
                        	<div class="nothing">
                        		<h2>You have chosen to review</h2><br>
                                <a href="preview.php?id=<?php echo $id ?>"><h1><u><?php echo $product_name ?></u></h1><br>
                            	<img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg"  /></a><br><br>
                            </div>
                            <div class="instructions">
                            	<h1>What makes a good review</h1>
                                <h3>Have you used this product?</h3>
                                <p>It's always better to review a product you have personally experienced.</p>
                                <h3>Educate your readers</h3>
                                <p>Provide a relevant, unbiased overview of the product. Readers are interested in the pros and the cons of the product.</p>
                                <h3>Be yourself, be informative</h3>
                                <p>Let your personality shine through, but it's equally important to provide facts to back up your opinion.</p>
                                <h3>Get your facts right!</h3>
                                <p>Nothing is worse than inaccurate information. If you're not really sure, research always helps.</p>
                                <h3>Stay concise</h3>
                                <p>Be creative but also remember to stay on topic. A catchy title will always get attention!</p>
                                <h3>Easy to read, easy on the eyes</h3>
                                <p>A quick edit and spell check will work wonders for your credibility. Also, break reviews into small, digestible paragraphs.</p>
                            </div>
                        </div>
                        <div class="right_side" style="width:825px;">
                        	<div class="nothing">
                        		<h1>Help others! Write a review</h1>
                                <hr class="style-one"></hr><br>
                            	<p>*All fields are mandatory</p>
                            	<p style="color:red;"><?php if (!empty($errors)) foreach($errors as $error) echo $error;?></p>
                            	<br>
                              <form action="" method="post">
                                	<table width="100%" style="background-color:#EBE8E8;">
                                      <tr>
                                        <td width="20%"><h1>Review Title:</h1></td>
                                        <td width="80%">
                                        	<input style="line-height:1.5em;" type="text" id="title" name="title" maxlength="60" size="75" value="<?php if(isset($title)) echo $title?>"/>
                                        	<p>(Maximum 60 characters)</p>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><h1>Your Review:</h1></td>
                                        <td><p><strong>Please do not include:</strong> HTML, references to other retailers, pricing, personal information, any profane, inflammatory or copyrighted comments, or any copied content.
                                          </p>
                                            <p>
                                              <textarea name="review" id="review" onkeypress="if (this.value.length > 500) { return false; }" style="width:600px;height:100px;"><?php if(isset($review)) echo $review?></textarea>
                                            </p>
                                            <p>(Please make sure your review does not exceed 500 characters.) </p>
                                        </td>
                                      </tr>
                        
                                      
                                      <tr>
                                        <td><h1>Your Rating:</h1></td>
                                        <td>
                                        <div class="rating">
                                        	<input type="radio" name="rating" value="1"<?php if (isset($status1))echo $status1?>>&nbsp;1&nbsp;
                                            <input type="radio" name="rating" value="2"<?php if (isset($status2))echo $status2?>>&nbsp;2&nbsp;
                                            <input type="radio" name="rating" value="3"<?php if (isset($status3))echo $status3?>>&nbsp;3&nbsp;
                                            <input type="radio" name="rating" value="4"<?php if (isset($status4))echo $status4?>>&nbsp;4&nbsp;
                                            <input type="radio" name="rating" value="5"<?php if (isset($status5))echo $status5?>>&nbsp;5&nbsp;
										</div>
                                        <p>&nbsp;</p>
                                        <p>(Click to rate on scale of 1-5)</p>
										</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <div>
                                        	<input type="hidden" name="product_id" id="product_id" value="<?php echo $id ?>" />
                                            <input style="border:1px solid black;" type="submit" name="submit" value="Submit" />
                                        </div>
                                        </td>
                                      </tr>
                                    </table>
                                </form>
							</div>
                        </div>
                    	<div class="clear"></div>
                    </div>
				</div>
		</div>
        <div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>
