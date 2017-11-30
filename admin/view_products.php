<?php
include '../init.php';
include '../includes/product_query.php';
if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = strip_tags($data);
  $data = preg_split('/[\s]+/', $data);
  return $data;
}
function search_product($search) {
	$i = 0;
	$where = "";
	foreach ($search as $key=>$value) {
		$where .= "`product_name` LIKE '%$value%' OR `details` LIKE '%$value%' OR `category` LIKE '%$value%' OR `subcategory` LIKE '%$value%' OR `brand` LIKE '%$value%'";
		if ($key != (count($search) - 1)) {
			$where .= " OR ";
		}
	}
	$sql = mysql_query("SELECT * FROM `products` WHERE $where");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$id[$i]				= $row["id"];
			$product_name[$i]	= $row["product_name"];
			$price[$i]			= $row["price"];
			$details[$i]		= $row["details"];
			$category[$i]		= $row["category"];
			$subcategory[$i]	= $row["subcategory"];
			$brand[$i]			= $row["brand"];
			$date_added[$i]		= $row["date_added"];
			$i = $i + 1;
		}
	} else {
		return 0;
	}
	return array($id, $product_name, $price, $details, $category, $subcategory, $brand, $date_added);
}

list($id, $product_name, $price, $details, $category, $subcategory, $brand, $date_added) = get_all_products();

if (isset($_POST['submit'])) {
	if (!empty($_POST['search'])) {
		$search = test_input($_POST['search']);
		list($id, $product_name, $price, $details, $category, $subcategory, $brand, $date_added) = search_product($search);
	}
}
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != '') {
	// remove item from system and delete its picture
	// delete from database
	$id_to_delete = $_POST['index_to_remove'];
	
	$sql = mysql_query("SELECT subcategory FROM products WHERE id='$id_to_delete'");
	$row = mysql_fetch_array($sql);
	$subcategory = $row['subcategory'];
	$sql = mysql_query("DELETE FROM products WHERE id='$id_to_delete' LIMIT 1");
	$sql = mysql_query("DELETE FROM product_specs WHERE product_id='$id_to_delete' LIMIT 1");
	$sql = mysql_query("DELETE FROM ". $subcategory ."_spec_value WHERE product_id='$id_to_delete' LIMIT 1");
	$sql = mysql_query("DELETE FROM product_review WHERE product_id='$id_to_delete'");
	// unlink the image from server
	// Remove The Pic -------------------------------------------
    $pictodelete1 = ($_SERVER['DOCUMENT_ROOT'].'/smart-store/admin/inventory_images/products/'.$id_to_delete.'/'.$id_to_delete.".jpg");
	$pictodelete2 = ($_SERVER['DOCUMENT_ROOT'].'/smart-store/admin/inventory_images/products/'.$id_to_delete.'/'.$id_to_delete."_1.jpg");
	$pictodelete3 = ($_SERVER['DOCUMENT_ROOT'].'/smart-store/admin/inventory_images/products/'.$id_to_delete.'/'.$id_to_delete."_2.jpg");
    if (file_exists($pictodelete1)) {
		unlink($pictodelete1);
		unlink($pictodelete2);
		unlink($pictodelete3);
		rmdir($_SERVER['DOCUMENT_ROOT'] . '/smart-store/admin/inventory_images/products/' . $id_to_delete);		
    }
	
	header("Location: view_products.php"); 
    exit();
}

?>

	<?php include 'header.php'; ?>
        <div id="view_products">
        	<h1>Smart Store Products</h1>
            <form action="" method="POST" onSubmit="if (this.search.value == 'Search for Products' || this.pwd.value == '') {return false;}" >
            	<input type="text" name="search" id="search" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}"/>
                <input type="submit" name="submit" value="Search" />
            </form><br />
            <table width="100%" border="1">
              <tr>
                <td><h1>Product Name</h1></td>
                <td><h1>Details</h1></td>
                <td><h1>Price</h1></td>
                <td><h1>Category</h1></td>
                <td><h1>Subcategory</h1></td>
                <td><h1>Brand</h1></td>
                <td><h1>Date Added</h1></td>
              </tr>
              <?php 
              for ($i = 0; $i < count($id); $i++) {
				  ?>
              <tr>
                <td><a href="edit_product.php?id=<?php echo $id[$i] ?>"><p><?php echo $product_name[$i] ?></p><p><img src="inventory_images/products/<?php echo $id[$i] ?>/<?php echo $id[$i] ?>.jpg" width="auto" height="100" /></a></p></td>
                <td><p><?php echo $details[$i] ?></p></td>
                <td><p>$<?php echo $price[$i] ?></p></td>
                <td><p><?php echo $category[$i] ?></p></td>
                <td><p><?php echo $subcategory[$i] ?></p></td>
                <td><p><?php echo strtoupper($brand[$i]) ?></p></td>
                <td><p><?php echo date_format(date_create_from_format('Y-m-d', $date_added[$i]), 'd-m-Y') ?></p></td>
                <td>
                <form action="" method="post" onsubmit="return confirm('Confirm Delete?');">
                <input type="submit" name="delete_<?php echo $id[$i]?>" value="Delete" />
                <input name="index_to_remove" type="hidden" value="<?php echo $id[$i] ?>" />
                </form></td>
              </tr>
              <?php 
              }?>
            </table>
		</div>
        <div class="clear"></div>
        <div id="footer">
        	<p>All rights reserved by Smart Store</p>
        </div>
	</div>
</body>
</html>