<?php
include '../init.php';
include '../includes/product_query.php';

if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}
function exists_id($id) {
	$sql = mysql_query("SELECT subcategory FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		$row = mysql_fetch_array($sql);
		return $row['subcategory'];
	} else {
		return false;
	}
}

function test_input($data) {
  $data = trim($data);
  $data = mysql_real_escape_string($data);
  $data = stripslashes($data);
  $data = strip_tags($data);
  $data = htmlspecialchars($data);
  $data = preg_split('/[\s]+/', $data);
  $data	= implode(" ",$data);
  return $data;
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
	header('Location: page_not_found.php');
	exit();
} else {
	$result = exists_id($_GET['id']);
	if ($result === false) {
		header('Location:page_not_found.php');
		exit();
	} else {
		$subcategory = $result;
	}
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if (preg_replace('#[^A-Za-z]#i', '', $_GET['id'])) {
    		header('Location:page_not_found.php');
			exit();
		}
		$sql = mysql_query("SELECT * FROM products WHERE id='".$_GET['id']."'");
		$productCount = @mysql_num_rows($sql); // count the output amount
		if ($productCount > 0) {
	    	while($row = mysql_fetch_array($sql)){
				$brand			= $row["brand"];
				$product_name	= $row["product_name"];
				$price			= $row["price"];
				$details		= $row["details"];
				$category		= $row["category"];
				$subcategory	= $row["subcategory"];
        	}
    	}
	}
}
if (isset($_POST['submit'])) {
	$k = 0;
	foreach ($_POST as $key => $value){
		$index[$k] = $key;
		$val[$k] = addslashes(test_input($value));
		$k++;
	}
	array_pop($val);
	$field = get_fields($subcategory);
	$query = "";
	$where = array_combine($field, $val);
	foreach ($where as $key=>$value) {
		$query .= "`".$key."`='".$value."'";
		if (end(array_keys($where)) != $key) {
			$query .= ",";
		}
	}
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$sql = mysql_query("UPDATE ".$subcategory."_spec_value SET $query WHERE `product_id`=".$_GET['id']);
	$sql = mysql_query("UPDATE product_specs SET spec_one='$val[8]', spec_two='$val[9]', spec_three='$val[10]', spec_four='$val[11]' WHERE `product_id`=".$_GET['id']);
	$errors[] = 'Updated successfully.';
}

if (isset($_POST['update'])) {
	$product_name	= test_input($_POST['product_name']);
	$brand			= test_input($_POST['brand']);
	$details		= test_input($_POST['details']);
	$price			= $_POST['price'];
	$category		= $_POST['category'];
	
	if (empty($product_name)) {
		$errors[] = 'Enter a Product Name.';
		echo '<style type="text/css">
        #product_name{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($brand)) {
		$errors[] = 'Enter a Brand.';
		echo '<style type="text/css">
        #brand{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($details)) {
		$errors[] = 'Enter details for Product.';
		echo '<style type="text/css">
        #details{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($price)) {
		$errors[] = 'Enter Price in US Dollors.';
		echo '<style type="text/css">
        #price{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($category)) {
		$errors[] = 'Select a Category.';
		echo '<style type="text/css">
        #category{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($_POST['subcategory'])) {
		$errors[] = 'Select a Subcategory.';
		echo '<style type="text/css">
        #subcategory{
			border:1px solid red;
		}
        </style>';
	} else $subcategory	= $_POST['subcategory'];
	
	if  (empty($errors)) {
		$sql = mysql_query("UPDATE products SET product_name='$product_name', details='$details', price='$price', brand='$brand', category='$category', subcategory='$subcategory' WHERE id=".$_GET['id']);
		$errors[] = 'Updated successfully.';
	}
}

?>

<?php include 'header.php'; ?>
        <div id="add_product">
        	<h1>Edit Product</h1>
            <div id="Tabs">
				<ul>
					<li id="li_tab1" onclick="tab('tab1')" ><a><p>Edit Details</p></a></li>
					<li id="li_tab2" onclick="tab('tab2')"><a><p>Edit Specification</p></a></li>
				</ul>
				<div id="Content_Area">
					<div id="tab1">
                    <?php 
					if (!empty($errors)) {
						foreach($errors as $error) {
							echo '<p>&#9658 '.$error.'</p>';	
						}
					}?>
			<form action="" method="POST" enctype="multipart/form-data">
            <table width="100%" border="1">
              <tr>
                <td>Product Name:</td>
                <td><input type="text" name="product_name" id="product_name" value="<?php echo $product_name ?>" size="40" /></td>
              </tr>
              <tr>
                <td>Price:</td>
                <td><input type="text" name="price" id="price" value="<?php echo $price ?>" maxlength="3" onkeypress="return isNumberKey(event)" /></td>
              </tr>
              <tr>
              <tr>
                <td>Brand:</td>
                <td><input type="text" name="brand" id="brand" value="<?php echo $brand ?>" size="40" /></td>
              </tr>
              <tr>
                <td>Category:</td>
                <td><select name="category" id="category" onchange="populate(this.id,'subcategory')">
          				<option value=""></option>
          				<option value="Software">Software</option>
          				<option value="Electronics">Electronics</option>
          				<option value="Home&Kitchen">Home&amp;Kitchen</option>
          			</select></td>
              </tr>
              <tr>
                <td>Subcategory:</td>
                <td><select name="subcategory" id="subcategory"></select></td>
              </tr>
              <tr>
                <td>Details:</td>
                <td><textarea name="details" id="details" cols="64" rows="7"><?php echo $details ?></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="update" id="update" value="Update"></td>
              </tr>
            </table>
            </form>

					</div>
	
					<div id="tab2" style="display: none;">
			<form action="" method="POST">
        	<?php $arr = get_spec_type($subcategory);
			for ($i = 0; $i < count($arr); $i++) { ?>
            	<table>
					<?php unset($array); $array = get_spec_field($subcategory, $i + 1);?>
                    <h2><?php echo strtoupper($arr[$i])?></h2>
                    <?php for ($j = 0; $j < count($array); $j++) {?>
                    <tr>
                        <td style="width:190px;"><?php echo $array[$j]?></td>
                        <?php $index = preg_replace('/\s+/', '', $array[$j]);?>
                        <td style="border-right:none;"><input type="text" name="<?php echo $index ?>" value="<?php echo $value = get_spec_value($subcategory, $_GET['id'], $array[$j]) ?>" maxlength="100" size="40" /></td>
                    </tr>
                    <?php }?>
                </table>
				<?php 
			}?>
            <input type="submit" value="Update" name="submit" id="submit" />
        	</form>

					</div>
				</div>
			</div> 

		</div>
        <div class="clear"></div>
        <div id="footer">
        	<p>All rights reserved by Smart Store</p>
        </div>
	</div>
</body>
</html>