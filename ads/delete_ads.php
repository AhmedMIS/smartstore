<h2>Your ads:</h2><br />
<?php

if (isset($_POST['submit'])) {
	$delete_id	= $_POST['delete_id'];
	$delete_ad 	= mysql_query("DELETE FROM ads WHERE id='$delete_id'");
	$pictodelete1 = ("../admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id.jpg");
	$pictodelete2 = ("../admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id" . "_1" . ".jpg");
	$pictodelete3 = ("../admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id" . "_2" . ".jpg");
    if (file_exists($pictodelete1)) {
		unlink($pictodelete1);
		unlink($pictodelete2);
		unlink($pictodelete3);
		rmdir("../admin/inventory_images/ads/$session_user_id/" . $delete_id);	
    }
}

$sql = mysql_query("SELECT * FROM ads WHERE user_id='$session_user_id'");
$productCount = @mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	$i = 0;
	while($row = mysql_fetch_array($sql)){
		$id[$i]				= $row['id'];
		$title[$i]			= $row['title'];
		$price[$i]			= $row['price'];
		$description[$i]	= $row['description'];
		$city[$i]			= $row['city'];
		$brand[$i]			= $row['brand'];
		$date_added[$i]		= $row['date_added'];
		$i = $i + 1;
	}
} else {
	$error = '<h1>There are no ads to delete.</h1>';
}
if ($productCount > 0) {
	for ($i = 0; $i < count($id); $i++) {
	?>
    <a href="ads.php?id=<?php echo $id[$i] ?>">
	<div id="results">
	<table width="100%" border="1">
	  <tr>
		<td><p><?php echo date_format(date_create_from_format('Y-m-d', $date_added[$i]), 'd-m-Y'); ?></p></td>
		<td><h2><?php echo $title[$i] ?></h2></td>
		<td width="100"><p><strong>Rs.<?php echo $price[$i] ?></strong></p></td>
	  </tr>
	  <tr>
		<td valign="top" width="150"><img src="../admin/inventory_images/ads/<?php echo $session_user_id ?>/<?php echo $id[$i] ?>/<?php echo $id[$i] ?>.jpg" style="margin:0; max-width:150px; max-height:150px;" /></td>
		<td valign="top">
        <p><?php echo $description[$i] ?></p>
        <p><strong>Brand: </strong><?php echo $brand[$i] ?></p><br />
        <p><?php echo $city[$i] ?></p>
        </td>
		<td valign="top"><form action="" method="POST" onsubmit="return confirm('Confirm Delete?');"><input type="hidden" name="delete_id" value="<?php echo $id[$i] ?>" /><input type="submit" name="submit" value="Delete" /></form></td>
	  </tr>
	</table></div></a><br />
	<?php
	}
} else {
	echo $error;
}
?>