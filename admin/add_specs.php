<?php
include '../init.php';
include '../includes/product_query.php';

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
function exists_spec($id, $subcategory) {
	$sql = mysql_query("SELECT id FROM " . $subcategory . "_spec_value WHERE product_id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
	header('Location:page_not_found.php');
	exit();
} else {
	$result = exists_id($_GET['id']);
	if ($result === false) {
		header('Location:page_not_found.php');
		exit();
	} else {
		$max_id = max_id();
		if ($_GET['id'] != $max_id) {
			header('Location: page_not_found.php');
			exit();
		}
		$subcategory = $result;
	}
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if (preg_replace('#[^A-Za-z]#i', '', $_GET['id'])) {
    		header('Location:page_not_found.php');
			exit();
		}
		
	}
}
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

if (isset($_POST['submit'])) {
	$k = 0;
	foreach ($_POST as $key => $value){
		$index[$k] = $key;
		$val[$k] = test_input($value);
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
	$sql = mysql_query("UPDATE ".$subcategory."_spec_value SET $query WHERE `product_id`=".$_GET['id']);
	$sql = mysql_query("UPDATE product_specs SET spec_one='$val[8]', spec_two='$val[9]', spec_three='$val[10]', spec_four='$val[11]' WHERE `product_id`=".$_GET['id']);
	header('Location:temp.php?success');
	exit();
}

?>
<?php include 'header.php'; ?>
        <div id="add_product">
        	<h1>Add Specifications:</h1>
            <?php 
			if (!empty($errors)) {
				foreach ($errors as $error) {
					echo '<p>&#9658 '.$error.'</p>';
				}	
			}?>
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
                        <td style="border-right:none;"><input type="text" name="<?php echo $index ?>" maxlength="100" size="40" /></td>
                    </tr>
                    <?php }?>
                </table>
				<?php 
			}?>
            <input type="submit" value="Submit" name="submit" id="submit" />
        	</form>
		</div>
        <div class="clear"></div>
        <div id="footer">
        	<p>All rights reserved by Smart Store</p>
        </div>
	</div>
</body>
</html>