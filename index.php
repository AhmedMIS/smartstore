<?php
include 'init.php';
include 'includes/head.php';

?>

<head>
<title>Smart Store</title>
</head>
<body>
	<div class="wrap">
		<div class="header">
			<?php include 'includes/header.php'; ?>
			<div class="menu">
				<?php include 'includes/menu.php'; ?>
			</div>
			<div class="header_bottom">
				<div class="header_bottom_left">
					<div class="section group">
						<div class="listview_1_of_2 images_1_of_2">
							<div class="listimg listimg_2_of_1">
								<?php list($id, $product_name, $details, $category, $subcategory) = min_id(); ?>
								<a href="preview.php?id=<?php echo $id ?>"> <img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg"  style="max-height:150px; max-width:150px;" /></a>
							</div>
                            <div class="text list_2_of_1" style="height:150px;">
								<h2 style="font-size:13px;"><?php echo $product_name ?></h2>
								<p><?php echo $details ?></p><br>
								<div class="button"><span><a href="preview.php?id=<?php echo $id?>">Add to cart</a></span></div>
							</div>
						</div>			
						<div class="listview_1_of_2 images_1_of_2">
							<div class="listimg listimg_2_of_1">
                    			<?php 
								list($array) = random_id($id);
								list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[0]);
								?>
								<a href="preview.php?id=<?php echo $id ?>"> <img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg" style="max-height:150px; max-width:150px;" /></a>
							</div>
							<div class="text list_2_of_1" style="height:150px;">
								<h2 style="font-size:13px;"><?php echo $product_name ?></h2>
								<p><?php echo $details ?></p><br>
								<div class="button"><span><a href="preview.php?id=<?php echo $id ?>">Add to cart</a></span></div>
							</div>
						</div>
					</div>
                    <div class="section group">
                        <div class="listview_1_of_2 images_1_of_2">
                            <div class="listimg listimg_2_of_1">
								<?php
                                list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[1]);
                                ?>
                                <a href="preview.php?id=<?php echo $id ?>"> <img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg" style="max-height:150px; max-width:150px;" /></a>
							</div>
                            <div class="text list_2_of_1" style="height:150px;">
                                <h2 style="font-size:13px;"><?php echo $product_name ?></h2>
                                <p><?php echo $details ?></p><br>
                                <div class="button"><span><a href="preview.php?id=<?php echo $id ?>">Add to cart</a></span></div>
                            </div>
						</div>
                        <div class="listview_1_of_2 images_1_of_2">
                        	<div class="listimg listimg_2_of_1">
								<?php
                                list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[2]);
                                ?>
                                <a href="preview.php?id=<?php echo $id ?>"> <img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg" style="max-height:150px; max-width:150px;" /></a>
							</div>
                            <div class="text list_2_of_1" style="height:150px;">
                            	<h2 style="font-size:13px;"><?php echo $product_name ?></h2>
                                <p><?php echo $details ?></p><br>
                                <div class="button"><span><a href="preview.php?id=<?php echo $id ?>">Add to cart</a></span></div>
							</div>
						</div>
                    </div>
				</div>
                <div class="header_bottom_right_images">
                    <div id="slideshow">
                        <ul class="slides">
                            <li><a href="#"><img src="images/1.jpg" alt="Marsa Alam underawter close up" height="342px" /></a></li>
                            <li><a href="#"><img src="images/2.jpg" alt="Turrimetta Beach - Dawn" height="342px"/></a></li>
                            <li><a href="#"><img src="images/3.jpg" alt="Power Station" height="342px"/></a></li>
                            <li><a href="#"><img src="images/4.jpg" alt="Colors of Nature" height="342px"/></a></li>
                        </ul>
                        <span class="arrow previous"></span>
                        <span class="arrow next"></span>
                    </div>
                </div>
            </div>
			<div class="clear"></div>
			<div class="main">
				<div class="content">
					<div class="content_top">
						<div class="heading">
							<h3>Feature Products</h3>
						</div>
<!--    		<div class="sort">
    		<p>Sort by:
    			<select>
    				<option>Lowest Price</option>
    				<option>Highest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="show">
    		<p>Show:
    			<select>
    				<option>4</option>
    				<option>8</option>
    				<option>12</option>
    				<option>16</option>
    				<option>20</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="page-no">
    			<p>Result Pages:<ul>
    				<li><a href="#">1</a></li>
    				<li class="active"><a href="#">2</a></li>
    				<li><a href="#">3</a></li>
    				<li>[<a href="#"> Next>>></a >]</li>
    				</ul></p>
    		</div>
 -->    			<div class="clear"></div>
					</div>
                    <div class="section group">
                      <?php 
                      $id = max_id();
                      list($array) = random_id($id);
                      for ($i = 0; $i < 4; $i++){
                          
                          list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[$i]);
                      ?><a href="preview.php?id=<?php echo $array[$i] ?>">
                            <div class="grid_1_of_4 images_1_of_4">
                                 <img src="admin/inventory_images/products/<?php echo $array[$i] ?>/<?php echo $array[$i] ?>.jpg" width="auto" height="150" alt="" />
                                 <h2><?php echo $product_name ?></h2>
                                 <p><?php echo $details ?></p>
                                 <p><span class="price">$<?php echo $price ?></span></p><!--
                                  <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $array[$i] ?>" class="cart-button">Add to Cart</a></span> </div>
                                 <div class="button"><span><a href="preview.php?id=<?php echo $array[$i] ?>" class="details">Details</a></span></div>-->
                            </div></a>
                            <?php }
                      ?>
                    </div>
					<div class="content_bottom">
						<div class="heading">
							<h3>New Products</h3>
						</div>
<!--    		<div class="sort">
    		<p>Sort by:
    			<select>
    				<option>Lowest Price</option>
    				<option>Highest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="show">
    		<p>Show:
    			<select>
    				<option>4</option>
    				<option>8</option>
    				<option>12</option>
    				<option>16</option>
    				<option>20</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="page-no">
    			<p>Result Pages:<ul>
    				<li><a href="#">1</a></li>
    				<li class="active"><a href="#">2</a></li>
    				<li><a href="#">3</a></li>
    				<li>[<a href="#"> Next>>></a >]</li>
    				</ul></p>
    		</div>
 -->    			<div class="clear"></div>
					</div>
                    <div class="section group">
                        <?php 
                          $id = max_id();
                          list($array) = order_by_date();
                          for ($i = 0; $i < 4; $i++){
                              
                              list($id, $product_name, $price, $details, $category, $subcategory) = product_data($array[$i]);
                        ?><a href="preview.php?id=<?php echo $array[$i] ?>">
                        <div class="grid_1_of_4 images_1_of_4">
                             <img src="admin/inventory_images/products/<?php echo $array[$i] ?>/<?php echo $array[$i] ?>.jpg" width="auto" height="150" alt="" />
                             <br><br>
                             <h2><?php echo $product_name ?></h2>
                             <p><?php echo $details ?></p>
                             <p><span class="price">$<?php echo $price ?></span></p>
                              <!--<div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $array[$i] ?>" class="cart-button">Add to Cart</a></span> </div>
                             <div class="button"><span><a href="preview.php?id=<?php echo $array[$i] ?>" class="details">Details</a></span></div>-->
                        </div></a>
                        <?php } ?>
                    </div>
				</div>
			</div>
		</div>
	
        <div class="footer">
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
</body>
</html>

