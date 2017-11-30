<?php
include 'init.php';

function exists_brand($brand) {
	$sql = mysql_query("SELECT brand FROM products WHERE brand='$brand'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}
function exists_subcategory($subcategory) {
	$sql = mysql_query("SELECT subcategory FROM products WHERE subcategory='$subcategory'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

if (!isset($_GET['brand']) || empty($_GET['brand'])) {
	header('Location: page_not_found.php');
	exit();
} else {
	if (exists_brand($_GET['brand']) === false) {
		header('Location: page_not_found.php');
		exit();
	}
	$brand = $_GET['brand'];
}

if (!isset($_GET['subcategory']) || empty($_GET['subcategory'])) {
	header('Location: page_not_found.php');
	exit();
} else {
	if (exists_subcategory($_GET['subcategory']) === false) {
	header('Location: page_not_found.php');
	exit();
	}
	$subcategory = $_GET['subcategory'];	
}

if (isset($_POST['cost']) && !empty($_POST['cost'])) {
	$_SESSION['flag'] = 1;
	$range = $_POST['cost'];
	if (empty($range) === false) {
		if ($range == '1,5') {
			list($min, $max) = explode(",", $range);
			$status1 = 'checked';
		} elseif ($range == '6,10') {
			list($min, $max) = explode(",", $range);
			$status2 = 'checked';
		} elseif ($range == '11,15') {
			list($min, $max) = explode(",", $range);
			$status3 = 'checked';
		} elseif ($range == '16,20') {
			list($min, $max) = explode(",", $range);
			$status4 = 'checked';
		} elseif ($range == '21,2000') {
			list($min, $max) = explode(",", $range);
			$status5 = 'checked';
		}
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
				<div class="main">
					<div class="content">
                    	<div class="content_top">
                        	<div class="back-links">
                            	<p><a href="index.php">Home</a> >><a href="brand.php?product=<?php echo $subcategory ?>"> <?php echo $subcategory ?></a> >> <?php echo $brand ?></p>
                        	</div>
                        	<div class="clear"></div>
                    	</div>
                    	<div class="rap">
                			<div class="left_side">
                    			<h2 class="refine">REFINE</h2>
                        		<h4 class="price">Price &nbsp; | &nbsp; <a href="javascript:history.go(0)"><u>Clear</u></a></h4>
                        		<form method="post" action="">
                        			<input type="radio" name="cost" <?php if (isset($status1))echo $status1?> value="<?php $arr = array(1, 5); echo $arr[0] . ',' . $arr[1]; ?>">&emsp;$1&emsp;-&emsp;$5&emsp;<font size="-2">(<?php echo $count = select_price(1, 5, $subcategory, $brand); ?>)</font><br>
                        			<input type="radio" name="cost" <?php if (isset($status2))echo $status2?> value="<?php unset($arr); $arr = array(6, 10); echo $arr[0] . ',' . $arr[1]; ?>">&emsp;$6&emsp;-&emsp;$10&emsp;<font size="-2">(<?php echo $count = select_price(6, 10, $subcategory, $brand); ?>)</font><br />
                        			<input type="radio" name="cost" <?php if (isset($status3))echo $status3?> value="<?php unset($arr); $arr = array(11, 15); echo $arr[0] . ',' . $arr[1]; ?>">&emsp;$11&emsp;-&emsp;$15&emsp;<font size="-2">(<?php echo $count = select_price(11, 15, $subcategory, $brand); ?>)</font><br />
                        			<input type="radio" name="cost" <?php if (isset($status4)) echo $status4?> value="<?php unset($arr); $arr = array(16, 20); echo $arr[0] . ',' . $arr[1]; ?>">&emsp;$16&emsp;-&emsp;$20&emsp;<font size="-2">(<?php echo $count = select_price(16, 20, $subcategory, $brand); ?>)</font><br />
                        			<input type="radio" name="cost" <?php if (isset($status5))echo $status5?> value="<?php unset($arr); $arr = array(21, 2000); echo $arr[0] . ',' . $arr[1]; ?>">&emsp;Above&emsp;$20&emsp;<font size="-2">(<?php echo $count = select_price(20, 2000, $subcategory, $brand); ?>)</font><br />
                        			<input type="submit" name="submit" value="Filter" style="width:100px;" />
                        		</form>
                    		</div>
                            <div class="right_side">
                                <h2 class="refine">Results:</h2>
                                <?php
                                if (!isset($_SESSION['flag']) || empty($_SESSION['flag']) === true) {
                                    unset($array);
                                    $array = product_by_brand($subcategory, $brand);
                                } elseif ($_SESSION['flag'] == 1) {
                                    unset($array);
                                    $array = product_by_cost($subcategory, $brand, $min, $max);
                                    if (empty($array)) {
                                        echo $message = 'There are no results to show.';
                                    }
                                    unset($_SESSION['flag']);
                                }
                                for ($i = 0; $i < count($array); $i++){ 
                                list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[$i]);
                                ?><a href="preview.php?id=<?php echo $id ?>">
                                <div class="grid_1_of_4 images_1_of_4" style="width:27%;">
                                    <img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg" width="auto" height="150" alt="" />
                                    <h2 style="height:10px;"><?php echo $product_name ?></h2><br />
                                    <p style="height:0px;"><?php echo $details ?></p><br />
                                    <p><span class="price" style="height:0px;">$<?php echo $price ?></span></p><!--
                                    <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $id ?>" class="cart-button">Add to Cart</a></span> </div>
                                    <div class="button"><span><a href="preview.php?id=<?php echo $id ?>" class="details">Details</a></span></div>-->
                                </div></a>
                			<?php } ?>
                			</div>
						</div><br><br>
                    <hr class="style-one" style="clear:both"></hr>
				</div>
			</div>
		</div>
        <div class="clear"></div>
    	<div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>