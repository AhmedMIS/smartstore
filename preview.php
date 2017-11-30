<?php include 'init.php';

function exists_id($id) {
	$sql = mysql_query("SELECT id FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
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
	$id	= mysql_real_escape_string(htmlentities(trim($_GET['id'])));
	$sql = mysql_query("SELECT * FROM products WHERE id ='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
    	if ($productCount > 0) {
	   		while($row = mysql_fetch_array($sql)){ 
				 $product_name	= $row["product_name"];
				 $price			= $row["price"];
				 $details		= $row["details"];
				 $category		= $row["category"];
				 $subcategory	= $row["subcategory"];
			} 
		}
	}
}
?>
<!DOCTYPE HTML><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Store</title>
<?php include 'includes/head.php';?>
<!-- SLIDER SCRIPT  -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/thumbslide.js"></script>

<link rel="stylesheet" type="text/css" href="css/thumbslide.css" />

<script>
//Initialization code:
$(document).ready(function(){ // on document load
		
		$("#thumbsliderdiv").imageSlider({ //initialize slider
			'thumbs': ["admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg","admin/inventory_images/products/<?php echo $id ?>/<?php echo $id . '_1' ?>.jpg","admin/inventory_images/products/<?php echo $id ?>/<?php echo $id . '_2' ?>.jpg"], // file names of images within slider. Default path should be changed inside thumbslide.js (near bottom)
			'auto_scroll':false,
			'auto_scroll_speed':4500,
			'stop_after': 0, //stop after x cycles? Set to 0 to disable.
			'canvas_width':400,
			'canvas_height':300 // <-- No comma after last option
			})
	});

</script><!-- SLIDER SCRIPT  -->
</head>
<body>
	<div class="wrap">
    	<div class="header">
    		<?php include 'includes/header.php'; ?>
            <div class="menu">
    			<?php include 'includes/menu.php'; ?>
			</div>
			<div class="clear"></div>
		</div>
	
        <div class="main">
            <div class="content">
                <div class="content_top">
                    <div class="back-links">
                        <p><a href="index.php">Home</a> >> <?php echo $category ?></p>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="section group">
                    <div class="cont-desc span_1_of_2">				
                        <div class="grid images_3_of_2">
                            <div id="thumbsliderdiv"></div>
                        </div>
                        <div class="desc span_3_of_2">
                            <h2><?php echo $product_name ?></h2>
                            <p><?php echo $details ?></p>					
                            <div class="price">
                                <p>Price: <span>$<?php echo $price ?></span></p>
                            </div>
                            <div class="available">
                                <ul style="display:flex;">
                                    <li><a href="write_review.php?id=<?php echo $id?>"><p><u>Write a review</u></p></a></li>
                                    <li><a href="preview.php?id=<?php echo $id ?>#reviews"><p><u>Read reviews</u></p></a></li>
                                    <li><a href="preview.php?id=<?php echo $id ?>#specs"><p><u>Read Specs</u></p></a></li>
                                </ul>
                            </div>
                            <div class="share">
                                <ul>
                                    <li><p><u>Payment options:</u> Cash on delivery, PayPal</p></li>
                                    <li><p><u>Shipping options:</u> Free all over Pakistan</p></li>
                                </ul>
                            </div>
                            <div class="add-cart">
                                <div class="button"><span>
                                    <form id="form1" name="form1" method="post" class="button" action="cart.php">
                                    <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
                                    <!--<input type="submit" name="button" id="button" class="button" value="Add to Cart" />-->
                                    <a href="cart.php" onclick="MyFunction();return false;">Add to Cart</a>
                                     </span></form>
                                    <script type="text/javascript">
                                    function MyFunction() {
                                        document.getElementById('form1').submit();
                                    }
                                    </script>
                                </div>
                        		<div class="clear"></div>
							</div>
						</div>
                        <div class="product-desc" style="font-family:'Monda', sans-serif;">
                            
                            <h2 style=" width:90%; background-color:#602D8D; font-size:medium; padding:5px;">KEY FEATURES OF <?php echo $product_name; ?></h2><br>
                            <?php list($one, $two, $three, $four, $five) = get_specs($id);?>
                            <ul>
                            <li><?php echo $one ?></li>
                            <li><?php echo $two ?></li>
                            <?php if (!empty($three)) {?>
                            <li><?php echo $three ?></li><?php }?>
                            <?php if (!empty($four)) {?>
                            <li><?php echo $four ?></li><?php }?>
                            <?php if (!empty($five)) {?>
                            <li><?php echo $five ?></li><?php }?>
                            </ul>
                            <br>
                            <h2 style=" width:90%; background-color:#602D8D; font-size:medium; padding:5px;">SPECIFICATIONS OF <?php echo $product_name; ?></h2><a name="specs" id="specs"></a>
                            <?php unset($arr); $subcategory = str_replace(' ', '_', $subcategory); $arr = get_spec_type(strtolower($subcategory)); ?>
                            
                            <?php for ($i = 0; $i < count($arr); $i++) { ?>
                            <table class="specs" width="90%"><br>
                             <?php unset($array); $array = get_spec_field(strtolower($subcategory), $i + 1);?>
                             <h2 style=" width:90%; background-color:#EDEDED; font-size:small; color:#000; padding:5px;"><?php echo strtoupper($arr[$i])?></h2>
                             <?php for ($j = 0; $j < count($array); $j++) {?>
                              <tr>
                                <td style="width:190px;"><?php echo $array[$j]?></td>
                                <?php $value = get_spec_value(strtolower($subcategory), $id, $array[$j])?>
                                <td style="border-right:none;"><?php if (empty($value)) $value = 'N/A'; echo $value ?></td>
                              </tr>
                              <?php }?>
                            </table>
                            <?php }?>

                        </div>
                        <div class="product-tags">
                        <a name="reviews" id="reviews"></a>
                            <h2>Product Reviews</h2>
                            <?php list($title, $username, $review, $rating, $date_added) = get_reviews($_GET['id'], 2); 
							if ($title !== null) {?>
							<h4>Top Reviews:</h4>
                            <?php
							}
                            for ($i = 0; $i <count($title); $i++) { ?>
                            
                            <table width="90%" border="1">
                            	<tr>
                                	<td width="20%"><h1>Rating: <?php echo $rating[$i]?> / 5</h1></td>
                                    <td width="80%"><h1><?php echo $title[$i]?></h1></td>
								</tr>
								<tr>
                                	<td><p style="text-decoration:underline;"><?php echo $username[$i]?></p>
                               	    <p><?php echo date_format(date_create_from_format('Y-m-d', $date_added[$i]), 'd-m-Y'); ?></p></td>
									<td><p><?php echo $review[$i]?></p></td>
								</tr>
							</table><hr class="style-one"></hr>
                            <?php } 
							if ($title !== null) {?>
                            <a href="read_reviews.php?id=<?php echo $_GET['id'] ?>&page=1"><h4 style="float:left;"><u>Read more reviews</u></h4></a>
                            <?php }?>
                            <!--<div class="button"><span><a href="#">Add Tags</a></span></div>-->
                        </div>				
					</div>
            <div class="rightsidebar span_3_of_1">
            	<div class="lister" style="border:1px solid #EBE8E8; padding:15px; ">
                	<h2 style="border-bottom: 1px solid black;">CATEGORIES</h2><br>
                    <ul>
                        <li><a href="brand.php?subcategory=mobile">&nbsp;Mobile Phones</a></li>
                        <li><a href="brand.php?subcategory=Television">&nbsp;Television</a></li>
                        <li><a href="brand.php?subcategory=Laptop">&nbsp;Laptop</a></li>
                        <li><a href="brand.php?subcategory=Camera">&nbsp;Camera</a></li>
                        <li><a href="brand.php?subcategory=Anti Virus">&nbsp;Anti Virus</a></li>
                        <li><a href="brand.php?subcategory=Air Conditioner">&nbsp;Air Conditioner</a></li>
                        <li><a href="brand.php?subcategory=Microwave Oven">&nbsp;Microwave Oven</a></li>
                    </ul>
				</div><!--
                <div class="subscribe">
                	<h2>Newsletters Signup</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.......</p>
                    	<div class="signup">
                        	<form>
                            	<input type="text" value="E-mail address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'E-mail address';">
                                <input type="submit" value="Sign up">
							</form>
						</div>
				</div>
                <div class="community-poll">
                    <h2>Community POll</h2>
                    <p>What is the main reason for you to purchase products online?</p>
                    <div class="poll">
                        <form>
                            <ul>
                                <li>
                                    <input type="radio" name="vote" class="radio" value="1">
                                    <span class="label"><label>More convenient shipping and delivery </label></span>
                                </li>
                                <li>
                                    <input type="radio" name="vote" class="radio" value="2">
                                    <span class="label"><label for="vote_2">Lower price</label></span>
                                </li>
                                <li>
                                    <input type="radio" name="vote" class="radio"  value="3">
                                    <span class="label"><label for="vote_3">Bigger choice</label></span>
                                </li>
                                <li>
                                    <input type="radio" name="vote" class="radio"  value="5">
                                    <span class="label"><label for="vote_5">Payments security </label></span>
                                </li>
                                <li>
                                    <input type="radio" name="vote" class="radio" value="6">
                                    <span class="label"><label for="vote_6">30-day Money Back Guarantee </label></span>
                                </li>
                                <li>
                                    <input type="radio" name="vote" class="radio" value="7">
                                    <span class="label"><label for="vote_7">Other.</label></span>
                                </li>
                            </ul>
                        </form>
                    </div>
				</div>-->
			</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<?php include 'includes/footer.php'; ?>
	</div>
</body>
</html>

