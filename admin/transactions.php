<?php 
include '../init.php';
include '../includes/product_query.php';
if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}

list($id, $user_id, $payer_email, $first_name, $payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city) = select_pending_transactions();

if (isset($_POST['index_to_adjust']) && $_POST['index_to_adjust'] != '') {
	$index_to_adjust	= $_POST['index_to_adjust'];
	$payment_status		= $_POST['payment_status'];
	if ($payment_status == 'Pending') {
		$sql = mysql_query("UPDATE `transactions` SET payment_status='Completed' WHERE id='$index_to_adjust'");
		header('Location: transactions.php');
		exit();
	}
}
if (isset($_POST['search_pending_txn'])) {
	if (!empty($_POST['txn_id'])) {
		$transaction_id = $_POST['txn_id'];
		list($id, $user_id, $payer_email, $first_name, $payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city) = select_by_txn_id($transaction_id);
	}
}
?>
	<?php include 'header.php'; ?>
    <div id="view_products">
    	<h1>Pending Transactions</h1>
        <form action="" method="post">
        	<label><h2>Enter transaction id:</h2></label>
        	<input type="text" name="txn_id" id="txn_id" />
            <input type="submit" name="search_pending_txn" id="search_pending_txn" value="Search" />
        </form><br />
        <?php if (!empty($id)) {?>
    	<table border="1">
          <tr>
            <td><h1>Sr#</h1></td>
            <td><h1>payer_email</h1></td>
            <td><h1>first_name</h1></td>
            <td><h1>txn_id</h1></td>
            <td><h1>payment_type</h1></td>
            <td><h1>amount</h1></td>
            <td><h1>payment_status</h1></td>
            <td><h1>payment_date</h1></td>
            <td><h1>address_city</h1></td>
          </tr>
          <?php for ($i = 0; $i < count($id); $i++) {?>
          <tr>
            <td><p><?php echo $i + 1 ?></p></td>
            <td><p><?php echo $payer_email[$i] ?></p></td>
            <td><p><?php echo $first_name[$i] ?></p></td>
            <td><p><?php echo $txn_id[$i] ?></p></td>
            <td><p><?php echo $payment_type[$i] ?></p></td>
            <td><p>$<?php echo $mc_gross[$i] ?></p></td>
            <td width="100"><form action="" method="post"><select name="payment_status" id="payment_status<?php echo $id[$i]?>" onchange="fun(<?php echo $id[$i] ?>)">
            <option value="Pending"<?php if($payment_status[$i] == 'pending')echo 'selected="selected"'?>>Pending</option>
            <option value="Completed"<?php if($payment_status[$i] == 'Completed')echo 'selected="selected"'?>>Completed</option>
            </select>
            <input name="index_to_adjust" type="hidden" value="<?php echo $id[$i] ?>" />
            <input name="payment_status" type="hidden" value="<?php echo $payment_status[$i]?>"  />
            <input type="submit" name="delete_<?php echo $id[$i]?>" id="change<?php echo $id[$i]?>" value="Change" disabled="disabled" /></form></td>
            <td><p><?php echo  date("M j, Y, g:i a",strtotime($payment_date[$i])) ?></p></td>
            <td><p><?php echo $address_city[$i] ?></p></td>
          </tr>
          <?php } ?>
        </table>
        <?php } else {
			echo '<h2>There are no pending transactions.</h2>';
		}?>
    </div>
	<div class="clear"></div>
	<div id="footer">
		<p>All rights reserved by Smart Store</p>
	</div>
</body>
</html>