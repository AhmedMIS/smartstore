<?php
include 'init.php';
include 'includes/head.php';

if (isset($_GET['subcategory'])) {
	if ($_GET['subcategory'] == 'television') {
		echo '<style type="text/css">
        #list_0{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'mobile') {
		echo '<style type="text/css">
        #list_1{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'camera') {
		echo '<style type="text/css">
        #list_2{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'Air Conditioner') {
		echo '<style type="text/css">
        #list_3{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'Microwave Oven') {
		echo '<style type="text/css">
        #list_4{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'laptop') {
		echo '<style type="text/css">
        #list_5{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'Anti Virus') {
		echo '<style type="text/css">
        #list_6{
			background-color: #cecece; color:black;
		}
        </style>';
	}
	if ($_GET['subcategory'] == 'television') {
		echo '<style type="text/css">
        #list_7{
			background-color: #cecece; color:black;
		}
        </style>';
	}
}

function exists_subcategory($subcategory) {
	$sql = mysql_query("SELECT subcategory from products WHERE subcategory='$subcategory'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

function search_product($search) {
	$i = 0;
	$where = "";
	foreach ($search as $key=>$value) {
		if (strlen($value) > 2) {
			$where .= "`product_name` LIKE '%$value%' OR `details` LIKE '%$value%' OR `category` LIKE '%$value%' OR `subcategory` LIKE '%$value%' OR `brand` LIKE '%$value%'";
			if ($key != (count($search) - 1)) {
				$where .= " OR ";
			}
		} else {
			$where .= "product_name='$value'";	
			if ($key != (count($search) - 1)) {
				$where .= " OR ";
			}
		}
	}
	
	$sql = mysql_query("SELECT id FROM `products` WHERE $where");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$array[$i] = $row['id'];
			$i = $i + 1;
		}
	} else {
		return 0;
	}
	return $array;
}

function test_input($data) {
  $data = trim($data);
  $data = mysql_real_escape_string($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  $data = preg_split('/[\s]+/', $data);
  return $data;
}


if (isset($_POST['search'])) {
	$search			= test_input($_POST['search']);
	$product_id		= search_product($search);
} else {
	if (isset($_GET['subcategory']) && isset($_GET['search']) && !empty($_GET['search'])&& !empty($_GET['subcategory'])) {
		$sub	= $_GET['subcategory'];
		$search	= test_input($_GET['search']);
		if (exists_subcategory($sub) === false) {
			header('Location:page_not_found.php');
			exit();
		}
			
		$where = "";
		$search	= implode(" ",$search);
		if ($search != $sub) {
			$search = preg_split('/[\s]+/', $search);
			foreach ($search as $key=>$value) {
				$where .= "`product_name` LIKE '%$value%' OR `details` LIKE '%$value%' OR `category` LIKE '%$value%' OR `brand` LIKE '%$value%'";
				if ($key != (count($search) - 1)) {
					$where .= " OR ";
				}
			}
			$search_again = mysql_query("SELECT id FROM products WHERE subcategory='$sub' AND ($where)");
		} else {
			$search = preg_split('/[\s]+/', $search);
			$search_again = mysql_query("SELECT id FROM products WHERE subcategory='$sub'");	
		}
		$i = 0;
		$productCount = @mysql_num_rows($search_again); // count the output amount
		if ($productCount > 0) {
			while($row = mysql_fetch_array($search_again)){
				$product_id[$i] = $row['id'];
				$i = $i + 1;
			}
		} else $product_id = 0;
	} else {
		header('Location:page_not_found.php');
		exit();
	}
}

?>
<head>
<title>Smart Store</title>
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
                	<div class="left_side" style="height:auto;">
                    	<h2 class="refine">Refine Search</h2>
                        <?php unset($array); $array = get_subcategories(); $search	= implode(" ",$search); ?>
                    	<ul><?php for ($i = 0; $i < count($array); $i++) {?>
                    	<a href="search.php?subcategory=<?php echo $array[$i] ?>&search=<?php echo $search ?>">
                        <li class="price" id="list_<?php echo $i ?>">>&nbsp;&nbsp;&nbsp;<?php echo strtoupper($array[$i]) ?> (<?php echo $count = count_subcategory($array[$i], $search); ?>)</li>
                        </a>
                    	<?php } ?>
                    	</ul><br><br>

                    </div>
                    <div class="right_side">
                    	<h2 class="refine">RESULTS:</h2>
                        <p class="results">Showing <?php if(!empty($product_id))echo count($product_id); else echo 0; ?> product<?php if(count($product_id) > 1) echo 's'?> for "<?php echo $search?>"</p>
<?php
	for ($i = 0; $i < count($product_id); $i++){
		if (empty($product_id) === true) {
			break;
		}
			list($id, $title, $price, $description, $category, $subcategory) = product_data($product_id[$i]); ?>
            <div class="grid_1_of_4 images_1_of_4" style="width:27%;">
            	<a href="preview.php?id=<?php echo $id ?>">
            	<img src="admin/inventory_images/products/<?php echo $id ?>/<?php echo $id ?>.jpg" width="auto" height="150" alt="" /></a>
                <h2 style="height:10px;"><?php echo $title ?></h2><br />
            	<p style="height:0px;"><?php echo $description ?></p><br />
            	<p><span class="price" style="height:0px;">$<?php echo $price ?></span></p>
            	<div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview.php?id=<?php echo $id ?>" class="cart-button">Add to Cart</a></span></div>
            	<div class="button"><span><a href="preview.php?id=<?php echo $id ?>" class="details">Details</a></span></div>
            </div>
            <?php
	}?>
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