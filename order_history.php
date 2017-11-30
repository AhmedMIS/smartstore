<?php 
list($payment_date, $mc_gross, $txn_id, $payment_type, $payment_status, $address_city, $pid) = select_order_history($session_user_id);

?>
<h2>Order History</h2>
<?php if (!empty($pid)) {?>
<table width="100%" border="1">
  <tr>
    <td><h1>Sr#</h1></td>
    <td><h1>Order Id</h1></td>
    <td><h1>Product name</h1></td>
    <td><h1>Quantity</h1></td>
    <td><h1>Total Amount</h1></td>
    <td><h1>Date</h1></td>
  </tr>
<?php for ($i = 0, $j = 0; $i < count($pid); $i++) {$k = 1;?>
  <tr>
    <td><p><?php echo $i + 1 ?></p></td>
    <td><p><?php echo $txn_id[$i] ?></p></td>
    <td><?php $pidstr[$i] = explode(",", $pid[$i]);
	foreach($pidstr[$i] as $key=>$value) {
		
		$product_id_pair = $pidstr[$i][$key];
		$id_quantity_pair = explode("-", $product_id_pair);
		$product_id = $id_quantity_pair[0];
		echo '<p style="border-bottom:1px solid #cbcbcb">('.($k).') '. $product_name = product_name_from_id($product_id).'</p>';
	$k = $k + 1;
	} ?></td>
    <td align="center"><?php $pidstr[$i] = explode(",", $pid[$i]);
	foreach($pidstr[$i] as $key=>$value) {
		$product_id_pair = $pidstr[$i][$key];
		$id_quantity_pair = explode("-", $product_id_pair);
		$product_quantity = $id_quantity_pair[1];
		echo '<p style="border-bottom:1px solid #cbcbcb">'. $product_quantity.'</p>';
	} ?></p></td>
    <td align="center"><p>$<?php echo $mc_gross[$i] ?></p></td>
    <td><p><?php echo date("M j, Y",strtotime($payment_date[$i])) ?></p></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php 
} else {
	echo '<h2>You have made no orders.</h2>';	
}?>
