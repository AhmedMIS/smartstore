<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php include 'head.php'; 
if (!isset($_GET['search']) || empty($_GET['search'])) {
	$errors[] = "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
}
$most_recent = ' ORDER BY date_added DESC';
$high_to_low = ' ORDER BY price DESC';
$low_to_high = ' ORDER BY price ASC';

if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = urldecode($_GET['search']);
	if (exists_category($search) === false) {
		if (exists_subcategory($search) === true){
			$ads_id = search_ads_from_get_variable_subcategory($search, $most_recent);
		} else {
			$errors[] = "<a href=\"javascript:history.go(-1)\">GO BACK</a>";
		}
	} else {
		$ads_id = search_ads_from_get_variable_category($search, $most_recent);
	}
	if (empty($ads_id)) {
		$errors[] = '<h2 style="padding:100px;text-align:center;border:1px solid black;">There are no results for "'.$search.'"</h2>';
	} else {
		$errors[] = '<p>There are '.count($ads_id).' ads for "'.$search.'"</p>';
	}
}
if(isset($_POST['DDlinks'])) {
	if ($_POST['DDlinks'] == 'Most Recent') {
		$selected = ' selected="selected"';
		if (exists_category($search) === false) {
			$ads_id = search_ads_from_get_variable_subcategory($search, $most_recent);
		} else {
			$ads_id = search_ads_from_get_variable_category($search, $most_recent);
		}  
	}
	if ($_POST['DDlinks'] == 'High to Low') {
		$selected1 = ' selected="selected"';
		if (exists_category($search) === false) {
			$ads_id = search_ads_from_get_variable_subcategory($search, $high_to_low);
		} else {
			$ads_id = search_ads_from_get_variable_category($search, $high_to_low);
		}   
	}
	if ($_POST['DDlinks'] == 'Low to High') {
		$selected2 = ' selected="selected"';
		if (exists_category($search) === false) {
			$ads_id = search_ads_from_get_variable_subcategory($search, $low_to_high);
		} else {
			$ads_id = search_ads_from_get_variable_category($search, $low_to_high);
		} 
	}
}
?>
</head>

<body>
	<div id="wrapper">
    	<?php include 'header.php' ?>
        <div class="top_links">
        <table width="100%" style="border-bottom:2px solid #cbcbcb">
          <tr>
            <td width="29%"><a href="categories.php"><h2>All Categories</a> → <?php if(isset($search))echo $search ?></h2></td>
            <td width="55%" align="right"><p>Sort by:</p></td>
            <td width="16%">
            <FORM NAME="DropDown" id="DropDown" method="post">
            <SELECT NAME="DDlinks" onChange="MyFunction();return false;">
            <OPTION VALUE="Most Recent"<?php if(isset($selected)) echo $selected ?>> Most Recent</OPTION>
            <OPTION VALUE="High to Low"<?php if(isset($selected1)) echo $selected1 ?>> Price:High to Low</OPTION>
            <OPTION VALUE="Low to High"<?php if(isset($selected2)) echo $selected2 ?>> Price:Low to High</OPTION>
            </SELECT>
            </FORM>
            </td>
          </tr>
        </table>
        </div>
        <br />
        <?php
		if (!empty($errors)) foreach ($errors as $error) echo $error;
		if (!empty($ads_id)) {
			for ($i = 0; $i < count($ads_id); $i++) {
				list($title, $description, $price, $brand, $date_added, $user_id, $city) = show_ad($ads_id[$i])?>
                <a href="ads.php?id=<?php echo $ads_id[$i] ?>">
                <br />
                <div id="results">
					<table width="100%">
					  <tr>
                      	<td width="150"><img src="../admin/inventory_images/ads/<?php echo $user_id ?>/<?php echo $ads_id[$i] ?>/<?php echo $ads_id[$i] ?>.jpg" width="150" height="150" /></td>
                        <td valign="top">
                        <h2><?php echo $title ?></h2>
                        <p style="color:#999"><?php echo $description ?></p><br />
                        <p><?php echo '<strong>Brand: </strong>'.$brand ?></p>
                        <p><strong><?php echo $city ?></strong></p>
                        <p style="color:#999"><?php echo date("M j, Y",strtotime($date_added)); ?></p></td>
                        <td valign="top" width="100"><h2>Rs.<?php echo $price ?></h2></td>
                      </tr>
					</table>
				</div>
                </a>
			<?php 
			}
		}?>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>	
	</div>
</body>
</html>
