<?php
include  $_SERVER['DOCUMENT_ROOT'] . '/smart-store/ads/head.php'; 
$most_recent = ' ORDER BY date_added DESC';
$high_to_low = ' ORDER BY price DESC';
$low_to_high = ' ORDER BY price ASC';
if (isset($_GET['search']) && !empty($_GET['search'])) {
	$search = urldecode($_GET['search']);
	
	if (exists_category($search) === false) {
		$ads_id = search_ads_from_get_variable_subcategory($search, $most_recent);
	} else {
		$ads_id = search_ads_from_get_variable_category($search, $most_recent);
	}
	if (empty($ads_id)) {
		$errors[] = 'There are no ads for "'.$search.'"';
	} else {
		$errors[] = 'There are '.count($ads_id).' ads for "'.$search.'"';
	}
}
   if(isset($_POST['DDlinks'])) {
      if ($_POST['DDlinks'] == 'Most Recent') {
		  $selected = true;
		  if (exists_category($search) === false) {
				$ads_id = search_ads_from_get_variable_subcategory($search, $most_recent);
			} else {
				$ads_id = search_ads_from_get_variable_category($search, $most_recent);
			}  
	  }
	  if ($_POST['DDlinks'] == 'High to Low') {
		  $selected1 = true;
		  if (exists_category($search) === false) {
				$ads_id = search_ads_from_get_variable_subcategory($search, $high_to_low);
			} else {
				$ads_id = search_ads_from_get_variable_category($search, $high_to_low);
			}   
	  }
	  if ($_POST['DDlinks'] == 'Low to High') {
		  $selected2 = true;
		  if (exists_category($search) === false) {
				$ads_id = search_ads_from_get_variable_subcategory($search, $low_to_high);
			} else {
				$ads_id = search_ads_from_get_variable_category($search, $low_to_high);
			} 
	  }
   } else {
     echo "task option is required";
   }
?>
<!DOCTYPE html>
<html>
<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
function MyFunction() {
document.getElementById('DropDown').submit();
}
</SCRIPT>
<body>
	<div id="wrapper">
    	<?php include $_SERVER['DOCUMENT_ROOT'] . '/smart-store/ads/header.php' ?>
        <table width="100%" border="1">
          <tr>
            <td width="29%"><a href="index.php">Home</a> → <?php echo $search ?></td>
            <td width="55%" align="right">Sort by:</td>
            <td width="16%">
            <FORM NAME="DropDown" id="DropDown" method="post">
            <SELECT NAME="DDlinks" onChange="MyFunction();return false;">
            <OPTION SELECTED>
            <OPTION VALUE="Most Recent" <?php if(isset($selected)) echo $selected ?>> Most Recent
            <OPTION VALUE="High to Low"<?php if(isset($selected1)) echo $selected1 ?>> High to Low
            <OPTION VALUE="Low to High"<?php if(isset($selected2)) echo $selected2 ?>> Low to High
            </SELECT>
            </FORM>
            </td>
          </tr>
        </table>
        
        <?php
		if (!empty($errors)) foreach ($errors as $error) echo $error;
		if (!empty($ads_id)) {
			for ($i = 0; $i < count($ads_id); $i++) {
				list($title, $description, $price, $brand, $date_added, $user_id, $city) = show_ad($ads_id[$i])?>
                <a href="ads.php?id=<?php echo $ads_id[$i] ?>">
                <div id="results">
					<table width="100%" border="1">
					  <tr>
                      	<td width="150"><img src="../admin/inventory_images/ads/<?php echo $user_id ?>/<?php echo $ads_id[$i] ?>/<?php echo $ads_id[$i] ?>.jpg" width="150" height="150" /></td>
                        <td valign="top">
                        <h2><?php echo $title ?></h2>
                        <p style="color:#999"><?php echo $description ?></p><br />
                        <p><?php echo $search.' → '.$brand ?></p><br />
                        <p><strong><?php echo $city ?></strong></p>
                        <p style="color:#999"><?php echo date("M j, Y",strtotime($date_added)); ?></p></td>
                        <td valign="top" width="100"><p>Rs.<?php echo $price ?></p></td>
                      </tr>
					</table>
				</div>
                </a>
			<?php 
			}
		}?>
	</div>
</body>
</html>