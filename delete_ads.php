<h2>Your ads:</h2><br />
<?php

if (isset($_POST['submit'])) {
	$delete_id	= $_POST['delete_id'];
	$delete_ad 	= mysql_query("DELETE FROM ads WHERE id='$delete_id'");
	$pictodelete1 = ("admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id.jpg");
	$pictodelete2 = ("admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id" . "_1" . ".jpg");
	$pictodelete3 = ("admin/inventory_images/ads/$session_user_id/" . $delete_id . "/$delete_id" . "_2" . ".jpg");
    if (file_exists($pictodelete1)) {
		unlink($pictodelete1);
		unlink($pictodelete2);
		unlink($pictodelete3);
		rmdir("admin/inventory_images/ads/$session_user_id/" . $delete_id);	
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
		$date_added[$i]		= $row['date_added'];
		$i = $i + 1;
	}
} else {
	$error = '<h1>There are no ads to delete.</h1>';
}
if ($productCount > 0) {
	for ($i = 0; $i < count($id); $i++) {
	?>
	
	<table width="100%" border="1">
	  <tr>
		<td width="190"><?php echo date_format(date_create_from_format('Y-m-d', $date_added[$i]), 'd-m-Y'); ?></td>
		<td><h1><?php echo $title[$i] ?></h1></td>
		<td><p>Rs.<?php echo $price[$i] ?></p></td>
	  </tr>
	  <tr>
		<td width="190" valign="top"><a href="ads/ads.php?id=<?php echo $id[$i] ?>"><img src="admin/inventory_images/ads/<?php echo $session_user_id ?>/<?php echo $id[$i] ?>/<?php echo $id[$i] ?>.jpg" style="margin:0; min-width:150px; min-height:150px;" /></a></td>
		<td width="600" valign="top"><p><?php echo $description[$i] ?></p></td>
		<td valign="top"><form action="" method="POST" onsubmit="return confirm('Confirm Delete?');"><input type="hidden" name="delete_id" value="<?php echo $id[$i] ?>" /><input type="submit" name="submit" value="Delete" /></form></td>
	  </tr>
	</table><br />
	<?php
	}
} else {
	echo $error;
}
?>