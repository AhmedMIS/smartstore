<?php

function product_name_from_id($id){
	$sql = mysql_query("SELECT product_name FROM products WHERE id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		$row = mysql_fetch_array($sql);
		$product_name = $row['product_name'];
		return $product_name;
	} else {
		return 0;	
	}
}

function select_order_history($id) {
	$i = 0;
	$sql = mysql_query("SELECT * FROM transactions WHERE user_id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$payment_date[$i]	= $row['payment_date'];
			$pid[$i]			= $row['product_id_array'];
			$mc_gross[$i]		= $row['mc_gross'];
			$txn_id[$i]			= $row['txn_id'];
			$payment_type[$i]	= $row['payment_type'];
			$payment_status[$i] = $row['payment_status'];
			$address_city[$i]	= $row['address_city'];
			$i = $i + 1;
		}	
		return array($payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city, $pid);
	} else {
		return 0;	
	}
}

function select_by_txn_id($transaction_id){
	$i = 0;
	$sql = mysql_query("SELECT * FROM transactions WHERE payment_status='Pending' AND txn_id='$transaction_id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$id[$i]				= $row['id'];
			$user_id[$i]		= $row['user_id'];
			$payer_email[$i]	= $row['payer_email'];
			$first_name[$i]		= $row['first_name'];
			$payment_date[$i]	= $row['payment_date'];
			$mc_gross[$i]		= $row['mc_gross'];
			$txn_id[$i]			= $row['txn_id'];
			$payment_type[$i]	= $row['payment_type'];
			$payment_status[$i] = $row['payment_status'];
			$address_city[$i]	= $row['address_city'];
			$i = $i + 1;
		}	
		return array($id, $user_id, $payer_email, $first_name, $payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city);
	} else {
		return 0;	
	}
}

function select_pending_transactions(){
	$i = 0;
	$sql = mysql_query("SELECT * FROM transactions WHERE payment_status='Pending'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$id[$i]				= $row['id'];
			$user_id[$i]		= $row['user_id'];
			$payer_email[$i]	= $row['payer_email'];
			$first_name[$i]		= $row['first_name'];
			$payment_date[$i]	= $row['payment_date'];
			$mc_gross[$i]		= $row['mc_gross'];
			$txn_id[$i]			= $row['txn_id'];
			$payment_type[$i]	= $row['payment_type'];
			$payment_status[$i] = $row['payment_status'];
			$address_city[$i]	= $row['address_city'];
			$i = $i + 1;
		}	
		return array($id, $user_id, $payer_email, $first_name, $payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city);
	} else {
		return 0;	
	}
}

function count_from_transactions($id) { 
	$i = 0;
	$amount = 0;
	$sql = mysql_query("SELECT count(user_id) FROM transactions WHERE user_id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		$row = mysql_fetch_row($sql);
		return $row[0];
	} else {
		return 0;	
	}
}

function amount_from_user_id($id) {
	$i = 0;
	$amount = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE user_id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$amount	+= $row['mc_gross'];
			$i = $i + 1;
		}	
		return $amount;
	} else {
		return 0;	
	}
}


function user_id_from_transactions() {
	$i = 0;
	$sql = mysql_query("SELECT DISTINCT user_id FROM transactions");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$user_id[$i]	= $row['user_id'];
			$i = $i + 1;
		}	
		return $user_id;
	} else {
		return 0;	
	}
}

function recently_sold(){
	$i = 0;$j = 0;$k = 0;
	$sql = mysql_query("SELECT product_id_array FROM transactions  LIMIT 5");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$product_id_string[$i] = $row['product_id_array'];
			$id_str_array[$i] = explode(",", $product_id_string[$i]); // Uses Comma(,) as delimiter(break point)
			//print_r($id_str_array[$i]);echo '<br>';
			$fullAmount = 0;
			foreach ($id_str_array[$i] as $key => $value) {
				$id_quantity_pair[$i] = explode("-", $value); // Uses Hyphen(-) as delimiter to separate product ID from its quantity
				//print_r($id_quantity_pair[$i]);echo '<br>';
				$product_id[$i] = $id_quantity_pair[$i][0]; // Get the product ID
				$product_quantity[$k] = $id_quantity_pair[$i][1]; // Get the quantity
				
				$sql1 = mysql_query("SELECT product_name,price FROM products WHERE id='$product_id[$i]' LIMIT 1");
				while($row1 = mysql_fetch_array($sql1)){
					$product_price[$j] = $row1["price"];
					$product_name[$j] = $row1["product_name"];
					$j = $j + 1;
				}
				$product_price[$k] = $product_price[$k] * $product_quantity[$k];
				$k = $k + 1;
			}
			$i = $i + 1;
		}
		
		return array($product_name, $product_quantity, $product_price);
	} else {
		return 0;	
	}
}

function all_time($payment_status){
	$total = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE payment_status='$payment_status'");
	$count = mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$total += $row['mc_gross'];
		}
		return $total;
	} else {
		return 0;	
	}
}

function this_year($payment_status){
	$serverDate = date('Y',time());
	$total = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE payment_date LIKE '%$serverDate%' AND payment_status='$payment_status'");
	$count = mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$total += $row['mc_gross'];
		}
		return $total;
	} else {
		return 0;	
	}
}

function this_week($payment_status){
	$total = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE `payment_date` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND payment_status='$payment_status'");
	$count = mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$total += $row['mc_gross'];
		}
		return $total;
	} else {
		return 0;	
	}
}

function today($payment_status){
	$serverDate = date('Y-m-d',time());
	$total = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE payment_date LIKE '%$serverDate%' AND payment_status='$payment_status'");
	$count = mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$total += $row['mc_gross'];
		}
		return $total;
	} else {
		return 0;	
	}
}

function this_month($payment_status){
	$serverDate = date('Y-m',time());
	$total = 0;
	$sql = mysql_query("SELECT mc_gross FROM transactions WHERE payment_date LIKE '%$serverDate%' AND payment_status='$payment_status'");
	$count = mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$total += $row['mc_gross'];
		}
		return $total;
	} else {
		return 0;	
	}
}

function get_fields($subcategory) {
	$i = 0;
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$sql = mysql_query("SELECT field FROM ".$subcategory."_spec_field");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$field[$i] = $row["field"];
			$i++;
		}
	}
	return $field;
}
function insert_specs($field, $subcategory, $product_id) {
	$i = 0;
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$where = ""; $here = ""; 
	foreach ($field as $key=>$value) {
		$where .= "`$value`";
		$here .= "''";
		if ($key != (count($field) - 1)) {
			$where .= ",";
			$here .= ",";
		}
	}
	$sql = mysql_query("INSERT INTO ".$subcategory."_spec_value (`product_id`, $where) VALUES ('$product_id',$here)");
	$sql = mysql_query("INSERT INTO product_specs (`product_id`,`spec_one`,`spec_two`,`spec_three`,`spec_four`) VALUES ('$product_id','','','','')");
}

function add_product($product_name, $price, $details, $category, $subcategory, $brand) {
	$sql = mysql_query("INSERT INTO products (product_name,price,details,category,subcategory,brand,date_added) VALUES ('".addslashes($product_name)."', '$price', '".addslashes($details)."', '$category', '$subcategory', '".addslashes($brand)."',now())");
	if ($sql) {
		return mysql_insert_id();
	} else {
		return false;
	}
}

function get_all_products() {
	$i = 0;
	$sql = mysql_query("SELECT * FROM products");
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

function get_cities() {
	$i = 0;
	$sql = mysql_query("SELECT DISTINCT city FROM users");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$city[$i] = $row["city"];
			$i = $i + 1;
		}
	} else {
		return 0;
	}
	return $city;
}

function username($id) {
	$sql = mysql_query("SELECT username from users WHERE user_id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$username = $row["username"];
			}
	} else {
		echo 'no';
	}
	return $username;
}

function get_reviews($id, $limit) {
//PREVIEW.PHP SHOW REVIEWS
	$i = 0;
	$sql = mysql_query("SELECT * FROM product_review WHERE product_id='$id' LIMIT $limit");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$user_id[$i]	= $row['user_id'];
			$username[$i]	= username($user_id[$i]);
			$title[$i]		= $row['title'];
			$review[$i]		= $row['review'];
			$rating[$i]		= $row['rating'];
			$date_added[$i]	= $row['date_added'];
			$i = $i + 1;
			}
	} else {
		echo '<br><br><h4 style="text-align:center;">There are no reviews yet for this product.</h4>';
		return null;
	}
	return array($title, $username, $review, $rating, $date_added);
}

function get_spec_value($subcategory, $id, $field) {
//PREVIEW.PHP SPEC VALUE
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$sql = mysql_query("SELECT `$field` FROM " . $subcategory . "_spec_value WHERE `product_id`='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$value	= $row["$field"];
			}
	} else echo 'no';
	return $value;

}

function get_spec_field($subcategory, $id) {
//PREVIEW.PHP SPEC FIELDS
	$i = 0;
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$sql = mysql_query("SELECT field FROM " . $subcategory . "_spec_field WHERE spec_type_id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i]	= $row['field'];
			$i = $i + 1;
		}
	} else echo 'no';
	return $arr;

}

function get_spec_type($subcategory) {
//PREVIEW.PHP SPEC TYPE
	$i = 0;
	$subcategory = strtolower(str_replace(" ", "_", $subcategory));
	$sql = mysql_query("SELECT * FROM " . $subcategory . "_spec_type");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i]	= $row['type'];
			$i = $i + 1;
			}
	} else echo 'no';
	return $arr;

}

function get_specs($id) {
//PREVIEW.PHP KEY FEATURES
	$sql = mysql_query("SELECT * FROM product_specs WHERE product_id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$one	= $row['spec_one'];
			$two	= $row['spec_two'];
			$three	= $row['spec_three'];
			$four	= $row['spec_four'];
			$five	= $row['spec_five'];
			}
	} else echo 'no';
	return array($one, $two, $three, $four, $five);
}

function count_subcategory($subcategory, $search) {
//SEARCH.PHP BROWSE CATEGORY
	$i =0;
	$where = "";
	if ($search != $subcategory) {
		$search = preg_split('/[\s]+/', $search);
		foreach ($search as $key=>$value) {
			if (strlen($value) > 2) {
				$where .= "`product_name` LIKE '%$value%' OR `details` LIKE '%$value%' OR `category` LIKE '%$value%' OR `brand` LIKE '%$value%'";
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
		$sql = mysql_query("SELECT count(id) FROM `products` WHERE subcategory='$subcategory' AND ($where)");
	} else {
		$sql = mysql_query("SELECT count(id) FROM `products` WHERE subcategory='$subcategory'");
	}
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		$row = mysql_fetch_row($sql);
		return $row[0];
	} else {
		return 0;
	}
}

function get_subcategories() {
	//SEARCH.PHP BROWSE SECTION
	$i =0;
	$sql = mysql_query("SELECT DISTINCT subcategory FROM products");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row['subcategory'];
			$i = $i + 1;
			}
	}
	return $arr;
}

function product_by_cost($subcategory, $brand, $min, $max){
	//BRAND_NAME GET ID TO SHOW PRODUCTS
	$i = 0;
	$sql = mysql_query("SELECT id FROM products WHERE subcategory='$subcategory' and brand='$brand' AND ABS(price)>='$min' AND ABS(price)<='$max'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row['id'];
			$i = $i + 1;
			}
	} else {
		
		return null;
	}
	return($arr);	
}

function product_by_brand($subcategory, $brand){
	//BRAND_NAME GET ID TO SHOW PRODUCTS
	$i = 0;
	$sql = mysql_query("SELECT id FROM products WHERE subcategory='$subcategory' and brand='$brand'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row['id'];
			$i = $i + 1;
			}
	} else {
		return null;
	}
	return($arr);	
}

function select_price($min, $max, $subcategory, $brand) {
	//BRAND.PHP?BRAND_NAME=BRAND&SUBCATEGORY=SUBCATEGORY
	$sql = mysql_query("SELECT count(id) FROM products WHERE subcategory='$subcategory' AND brand='$brand' AND ABS(price)>='$min' AND ABS(price)<='$max'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		$row = mysql_fetch_row($sql);
		return $row[0];
	} else {
		return 0;
	}
}

function brand_new_products($product) {
	//BRANDS SHOW NEW PRODUCTS
	$i = 0;
	$sql = mysql_query("SELECT id FROM products WHERE subcategory='$product' ORDER BY date_added DESC LIMIT 4");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row['id'];
			$i = $i + 1;
			}
	} else {
		return null;
	}
	return($arr);	
}

function brand_budget_products($product) {
	//BRANDS SHOW CHEAP PRODUCTS
	$i = 0;
	$sql = mysql_query("SELECT id FROM `products` WHERE subcategory='$product' ORDER BY ABS(price) ASC LIMIT 4");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row['id'];
			$i = $i + 1;
			}
	} else {
		return null;
	}
	return($arr);	
}

function menu_products($subcategory, $limit) {
	//PRODUCTS
	$i = 0;
	$sql = mysql_query("SELECT DISTINCT brand FROM products WHERE subcategory='$subcategory' $limit");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row["brand"];
			$i = $i + 1;			 
			}
	} else {
		return null;
	}
	return($arr);
}

function menu_brands() {
	//TOP BRANDS
	$i = 0;
	$sql = mysql_query("SELECT brand FROM products LIMIT 7");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$arr[$i] = $row["brand"];
			$i = $i + 1;			 
			}
	}
	return($arr);
}

function min_id() {
 	//SELECT MINIMUM ID
 	$sql = mysql_query("SELECT * FROM products WHERE id = ( select min(id) from products )");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             $id			= $row["id"];
			 $product_name	= $row["product_name"];
			 $details		= $row["details"];
			 $category		= $row["category"];
			 $subcategory	= $row["subcategory"];
        }
    }
 	return array($id, $product_name, $details, $category, $subcategory);
}

function max_id() {
 	//SELECT MAXIMUM ID
 	$sql = mysql_query("SELECT id FROM products WHERE id = ( select max(id) from products )");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             $id			= $row["id"];
        }
    }
 	return ($id);
}

function product_data($id) {
  	$sql = mysql_query("SELECT id,LEFT(product_name,20) as product_name,price, LEFT(details,20) as details,category,subcategory FROM products WHERE id='$id'");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			$id				= $row["id"];
			$product_name	= $row["product_name"];
			$price			= $row["price"];
			$details		= $row["details"];
			$category		= $row["category"];
			$subcategory	= $row["subcategory"];
        }
    } else echo 'no';
	if (strlen($product_name) == 20) {
		$product_name .= '....';
	}
	if (strlen($details) == 20) {
		$details .= '....';
	}
	return array($id, $product_name, $price, $details, $category, $subcategory);
}

function ads_data($id) {
  	$sql = mysql_query("SELECT LEFT(title,20) as title,price, LEFT(description,20) as description,category,subcategory FROM ads WHERE id='$id'");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			//$id				= $row["id"];
			$title			= $row["title"];
			$price			= $row["price"];
			$description	= $row["description"];
			$category		= $row["category"];
			$subcategory	= $row["subcategory"];
        }
    }else echo 'no';
	if (strlen($title) == 20) {
		$title .= '....';
	}
	if (strlen($description) == 20) {
		$description .= '....';
	}
	return array($title, $price, $description, $category, $subcategory);
}


function random_id($id) {
	//SELECT RANDOM ID
	$i = 0;
	$sql = mysql_query("SELECT * FROM products WHERE id NOT IN ('$id')ORDER BY RAND() DESC");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			$arr[$i]			= $row["id"];
			$i = $i + 1;			 
        }
    }
	return array($arr);
}

function order_by_date() {
	//ORDER BY DATE ADDED
	$i = 0;
	$sql = mysql_query("SELECT * FROM products ORDER BY date_added DESC LIMIT 4");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			$arr[$i]			= $row["id"];
			$i = $i + 1;			 
        }
    }
	return array($arr);
}

function select_category($category) {
	//SELECT CATEGORY ID IN PRODUCTS.PHP
	$i = 0;
	$sql = mysql_query("SELECT * FROM products WHERE category='$category'");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			$arr[$i]			= $row["id"];
			$i = $i + 1;			 
        }
    }else echo 'no';
	return array($arr);
}

function select_category_by_date($category) {
	//ORDER ALL BY DATE ADDED
	$i = 0;
	$sql = mysql_query("SELECT * FROM products WHERE category='$category' ORDER BY date_added DESC");
    $productCount = @mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){
			$arr[$i]			= $row["id"];
			$i = $i + 1;			 
        }
    }
	return array($arr);
}

function slider($id, $array) {

?>
<script>
var id = "<?php echo $id ?>";
    function example(id) {
      document.write(
        '<div class="example" id="' + id + '">' +
          '<div>' +
            '<ul>' +
			<?php
			for ($i = 0; $i < count($array); $i++) {
				?>
				'<li><a href="preview.php?id=<?php echo $array[$i] ?>"><img src="admin/inventory_images/products/<?php echo $array[$i] ?>/<?php echo $array[$i] ?>.jpg" width="auto" height="160"></a></li>' +
				
				<?php
			}
			?>
            '</ul>' +
          '</div>' +
        '</div>'
      );
    }
</script>


<?php	
}

?>