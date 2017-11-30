<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php';
$most_recent = ' ORDER BY date_added DESC';
$high_to_low = ' ORDER BY price DESC';
$low_to_high = ' ORDER BY price ASC';

if (isset($_POST['submit'])) {
	$search = test_input($_POST['search_ads']);
	$data	= implode(" ",$search);
	list($search_ad_id, $search_user_id)	= search_ad($search, $most_recent);
	if (empty($search_ad_id)) {
		$errors[] = '<h2 style="padding:100px;text-align:center;border:1px solid black;">There are no results for "'.$data.'"</h2>';	
	} else {
		$errors[] = '<p>There are '.count($search_ad_id).' results for "'.$data.'"</p>';
	}
}
if(isset($_POST['DDlinks'])) {
	$search = test_input($_POST['search']);
	if ($_POST['DDlinks'] == 'Most Recent') {
		$selected = ' selected="selected"';
		list($search_ad_id, $search_user_id)	= search_ad($search, $most_recent);
	}
	if ($_POST['DDlinks'] == 'High to Low') {
		$selected1 = ' selected="selected"';
		list($search_ad_id, $search_user_id)	= search_ad($search, $high_to_low);
	}
	if ($_POST['DDlinks'] == 'Low to High') {
		$selected2 = ' selected="selected"';
		list($search_ad_id, $search_user_id)	= search_ad($search, $low_to_high);
	}
}

?>
</head>
<body>
	<div id="wrapper">
		<?php include 'header.php'; ?>
        <div class="top_links">
		<table width="100%" style="border-bottom:2px solid #cbcbcb">
          <tr>
            <td width="29%"><a href="index.php"><h2>Home</a> → <?php if(isset($search))echo '"'.implode(" ",$search).'"' ?></h2></td>
            <td width="55%" align="right"><p>Sort by:</p></td>
            <td width="16%">
            <FORM NAME="DropDown" id="DropDown" method="post">
            <input type="hidden" name="search" value="<?php echo implode(" ",$search) ?>" />
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
        if (!empty($search_ad_id)) {
			for ($i = 0; $i < count($search_ad_id); $i++) {
				list($title, $description, $price, $brand, $date_added, $user_id, $city) = show_ad($search_ad_id[$i])?>
                <a href="ads.php?id=<?php echo $search_ad_id[$i] ?>">
                <br />
                <div id="results">
					<table width="100%">
					  <tr>
                      	<td width="150"><img src="../admin/inventory_images/ads/<?php echo $search_user_id[$i] ?>/<?php echo $search_ad_id[$i] ?>/<?php echo $search_ad_id[$i] ?>.jpg" width="150" height="150" /></td>
                        <td valign="top">
                        <h2><?php echo $title ?></h2>
                        <p style="color:#999"><?php echo $description ?></p><br />
                        <p><?php echo '<strong>Brand</strong>: '.$brand ?></p>
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