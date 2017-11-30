<h2>Your Messages:</h2><br />
<?php

if (isset($_GET['read']) && !empty($_GET['read'])) {
	$update_id = mysql_real_escape_string(htmlentities(trim($_GET['read'])));
	$update = mysql_query("UPDATE `private_messages` SET `opened`='1' WHERE id='$update_id'");
}
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
	$delete_id = mysql_real_escape_string(htmlentities(trim($_GET['delete'])));
	$delete = mysql_query("DELETE FROM `private_messages` WHERE id='$delete_id'");
}

$pages_query	= mysql_query("SELECT count(id) FROM private_messages WHERE to_id='$session_user_id'");
$productCount = @mysql_num_rows($pages_query);
if ($productCount > 0) {
	$result = @mysql_fetch_row($pages_query);
	if ($result[0] == 0) {
		echo '<h1>There are no messages.</h1>';
	} else {
		echo '<br>You have '.$result[0].' messages.';
		$sql = mysql_query("SELECT * FROM private_messages WHERE to_id='$session_user_id' ORDER BY time_sent DESC");
		$productCount = @mysql_num_rows($sql); // count the output amount
		if ($productCount > 0) {
			$i = 0;
			while($row = mysql_fetch_array($sql)){
				$id[$i]			= $row['id'];
				$sender[$i]		= $row['from_id'];
				$username[$i]	= username($row['from_id']);
				$subject[$i]	= $row['subject'];
				$message[$i]	= $row['message'];
				$time_sent[$i]	= $row['time_sent'];
				$opened[$i]		= $row['opened'];
				$i = $i + 1;
			}
		}?>
		<?php
		for ($i = 0; $i < $result[0]; $i++) {?><br />
        <div id="results">
		<table width="100%" border="1"
		<?php 
		if ($opened[$i] == 0) {
			?>
            bgcolor="#EDEDED"
			<?php 
		} else {
			 ?>
             bgcolor="#FFFFFF" 
             <?php 
		}?>>
			<tr>
				<td width="20%"><?php if ($opened[$i] == 0){?><p><a href="?id=inbox&read=<?php echo $id[$i] ?>">Mark as read</a></p><?php }?><p><a href="?id=inbox&delete=<?php echo $id[$i] ?>" onclick="return confirm('Confirm Delete?');">Delete</a></p></td>
				<td width="80%"><h1><?php echo $subject[$i]?></h1></td>
			</tr>
			<tr>
				<td><p style="text-decoration:underline;"><?php echo $username[$i]?></p>
					<p><?php echo date("M j, Y, g:i a",strtotime($time_sent[$i])); ?></p></td>
				<td><p><?php echo $message[$i]?></p></td>
			</tr>
		</table>
        </div><br /><hr class="style-one"></hr>
    <?php               
		}
	}
}?>