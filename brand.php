<?php
include 'init.php';

function exists_product($subcategory) {
	$sql = mysql_query("SELECT brand FROM products WHERE subcategory='$subcategory'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

function exists_category($category) {
	$sql = mysql_query("SELECT category FROM products WHERE category='$category'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
	
}

if (!isset($_GET['subcategory']) || empty($_GET['subcategory'])) {
	header('Location:page_not_found.php');
	exit();
} else {
	if (exists_product($_GET['subcategory']) === false) {
		header('Location:page_not_found.php');
		exit();
	}
	$subcategory = $_GET['subcategory'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Smart Store</title>
<?php include 'includes/head.php';?>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/responsiveslides.css">
  <link rel="stylesheet" href="css/demo.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="js/responsiveslides.min.js"></script>
	<script>
	    $(function () {
      // Slideshow 4
      $("#slider4").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
       
      });

    });
	</script>

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
						<div id="bori">
                            <div class="content_top">
                                <div class="back-links">
                                    <p><a href="index.php">Home</a> >> <?php echo $subcategory ?></p>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="rightsidebar span_3_of_1">
                                <h2><?php echo strtoupper($subcategory); ?> BRANDS</h2>
                                <?php unset($array); $limit = ""; $array = menu_products($subcategory, $limit); ?>
                                <ul><?php for ($i = 0; $i < count($array); $i++) {?>
                                    <li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=<?php echo $subcategory ?>"><?php echo $array[$i] ?></a></li>
                                    <?php } ?>
                                </ul><br><br>
                                <hr class="style-one"></hr>
                            </div>
                            <div class="callbacks_container">
                                <ul class="rslides" id="slider4">
                                    <li><img src="images/<?php echo $subcategory ?>_1.jpg">
            <!--                              <p class="caption">Celebrating 1 million moto customers.</p>-->
                                    </li>
                                    <li><img src="images/<?php echo $subcategory ?>_2.jpg">
            <!--                              <p class="caption">Asus Zenfone exclusive.</p>-->
                                    </li>
                                    <li><img src="images/<?php echo $subcategory ?>_3.jpg">
            <!--                              <p class="caption">Smartfones exclusive.</p>-->
                                    </li>
                                </ul>
                                <hr class="style-one" style="width: 81%;margin-left: 90px;"></hr>
                            </div>
                            <div class="down">
                                <?php unset($array);?>
                                <div class="content_bottom">
                                    <div class="clear"></div>
                                </div>
                                <div class="section group">
                                    <div class="content_top" style="margin-top:10px; padding-bottom:44px;">
                                        <div class="heading">
                                            <h3>New Products</h3>
                                        </div>
                                    </div>
                                </div>
                                    <?php 
                                    $array = brand_new_products($subcategory);
                                    for ($i = 0; $i < count($array); $i++){
                                        list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[$i]);
                                        ?><a href="preview.php?id=<?php echo $array[$i] ?>">
                                <div class="grid_1_of_4 images_1_of_4" style="width:19.8%;">
                                    <img src="admin/inventory_images/products/<?php echo $array[$i] ?>/<?php echo $array[$i] ?>.jpg" width="auto" height="150" alt="" />
                                    <h2 style="height:10px;"><?php echo $product_name ?></h2>
                                    <p style="height:0px;"><?php echo $details ?></p>
                                    <p><span class="price" style="height:0px;">$<?php echo $price ?></span></p><!--
                                    <div class="button" style="margin-left: 0px;"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $array[$i] ?>" class="cart-button">Add to Cart</a></span> </div>
                                    <div class="button" style="margin-left: 9px;"><span><a href="preview.php?id=<?php echo $array[$i] ?>" class="details">Details</a></span></div>-->
                                </div></a>
                            <?php } ?>
                            </div><br><br>
                            <hr class="style-one" style="clear:both"></hr>
                        
                            <div class="down">
                                <?php unset($array); ?>
                                <div class="section group">
                                    <div class="content_top" style="margin-top:10px; padding-bottom:44px;">
                                        <div class="heading">
                                            <h3>Budget Products</h3>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                    $array = brand_budget_products($subcategory);
                                    for ($i = 0; $i < count($array); $i++){
                                        list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[$i]);
                                        ?><a href="preview.php?id=<?php echo $array[$i] ?>">
                                <div class="grid_1_of_4 images_1_of_4" style="width:19.8%;">
                                    <img src="admin/inventory_images/products/<?php echo $array[$i] ?>/<?php echo $array[$i] ?>.jpg" width="auto" height="150" />
                                    <h2 style="height:10px;"><?php echo $product_name ?></h2>
                                    <p style="height:0px;"><?php echo $details ?></p>
                                    <p><span class="price" style="height:0px;">$<?php echo $price ?></span></p><!--
                                    <div class="button" style="margin-left: 0px;"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $array[$i] ?>" class="cart-button">Add to Cart</a></span> </div>
                                    <div class="button" style="margin-left: 9px;"><span><a href="preview.php?id=<?php echo $array[$i] ?>" class="details">Details</a></span></div>-->
                                </div></a>
                                <?php } ?>
                            </div><br><br>
							<hr class="style-one" style="clear:both"></hr>
						</div>
					</div>
				</div>
        	<div class="clear"></div>
		</div>
		<div class="footer">
   	 	 <?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>

