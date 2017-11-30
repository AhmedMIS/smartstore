<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Smart Sale</title>
<link rel="shortcut icon" href="../images/title.png" />
<link href="style.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/bjqs.css">

    <!-- some pretty fonts for this demo page - not required for the slider 
    <link href='http://fonts.googleapis.com/css?family=Source+Code+Pro|Open+Sans:300' rel='stylesheet' type='text/css'> -->

    <!-- demo.css contains additional styles used to set up this demo page - not required for the slider --> 
    <link rel="stylesheet" href="../css/demo.css">

    <!-- load jQuery and the plugin -->
    <script src="../js/jquery-1.7.1.min.js"></script>
    <script src="../js/bjqs-1.3.min.js"></script>

<script type="text/javascript">
	function LinkUp() 
	{
		var number = document.DropDown.DDlinks.selectedIndex;
		location.href = document.DropDown.DDlinks.options[number].value;
	}
	function MyFunction() {
		document.getElementById('DropDown').submit();
	}

	$(document).ready(function() {
    $('#pmMessage,#description').bind('cut copy paste', function(event) {
        event.preventDefault();
    });

});
</script>
<script class="secret-source">
            jQuery(document).ready(function($) {
              
              $('#banner-slide').bjqs({
                animtype      : 'slide',
                height        : 320,
                width         : 400,
                responsive    : true,
                randomstart   : true
              });
              
            });
</script>

<?php
include '../init.php';

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

function get_old_password($user_id) {
	$sql = mysql_query("SELECT password from users WHERE user_id='$user_id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$password = $row["password"];
		}
	} else {
		return false;
	}
	return $password;
}

function search_ad($search, $order) {
	$i = 0;
	$where = "";
	foreach ($search as $key=>$value) {
		if (strlen($value) > 3) {
			$where .= "`title` LIKE '%$value%' OR `description` LIKE '%$value%' OR `subcategory` LIKE '%$value%' OR `brand` LIKE '%$value%'";
			if ($key != (count($search) - 1)) {
				$where .= " OR ";
			}
		} else {
			$where .= "title='$value'";	
			if ($key != (count($search) - 1)) {
				$where .= " OR ";
			}
		}
	}
	$sql = mysql_query("SELECT id,user_id FROM `ads` WHERE $where$order");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql)){
			$id[$i]			= $row['id'];
			$user_id[$i]	= $row['user_id'];
			$i = $i + 1;
			}
	} else {
		return 0;
	}
	return array($id, $user_id);
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

function exists_id($id) {
	$sql = mysql_query("SELECT id FROM ads WHERE id=$id");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

function show_ad($id){
	$sql = mysql_query("SELECT * FROM ads WHERE id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$title			= $row['title'];
			$user_id		= $row['user_id'];
			$description	= $row['description'];
			$price			= $row['price'];
			$category		= $row['category'];
			$subcategory	= $row['subcategory'];
			$brand			= $row['brand'];
			$date_added		= $row['date_added'];
			$city			= $row['city'];
		}
		return array($title, $description, $price, $brand, $date_added, $user_id, $city, $category, $subcategory);
	} else {
		return 0;	
	}
}

function search_ads_from_get_variable_subcategory($subcategory, $order){
	$i = 0;
	$sql = mysql_query("SELECT id FROM ads WHERE subcategory='$subcategory'$order");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$id[$i] = $row['id'];
			$i = $i +1;
		}
		return $id;
	} else {
		return 0;	
	}
}

function search_ads_from_get_variable_category($category, $order){
	$i = 0;
	$sql = mysql_query("SELECT id FROM ads WHERE category='$category'$order");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$id[$i] = $row['id'];
			$i = $i +1;
		}
		return $id;
	} else {
		return 0;	
	}
}

function get_subcategory($id){
	$i = 0;
	$sql = mysql_query("SELECT subcategory FROM ads_subcategory WHERE category_id='$id'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$subcategory[$i] = $row['subcategory'];
			$i = $i +1;
		}
	}
	return $subcategory;
}

function get_id_from_category($category){
	$category = urldecode($category);
	$sql = mysql_query("SELECT id FROM ads_category WHERE category='$category'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$id = $row['id'];
		}
	}
	return $id;
}

function exists_category($category){
	$sql = mysql_query("SELECT id FROM ads_category WHERE category='$category'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		return true;
	} else {
		return false;	
	}
}
function exists_subcategory($subcategory){
	$sql = mysql_query("SELECT id FROM ads_subcategory WHERE subcategory='$subcategory'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		return true;
	} else {
		return false;	
	}
}

function get_category(){
	$i = 0;
	$sql = mysql_query("SELECT category FROM ads_category");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$category[$i] = $row['category'];
			$i = $i +1;
		}
	}
	return $category;
}

function count_ads($category){
	$sql = mysql_query("SELECT count(category) FROM ads WHERE category='$category'");
	$count = @mysql_num_rows($sql);
	if ($count > 0) {
		$row = mysql_fetch_row($sql);
		return $row[0];
	} else {
		return 0;	
	}
}

?>
