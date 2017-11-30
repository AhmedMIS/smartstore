<?php 
include '../init.php';
include '../includes/product_query.php';
if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}
?>
	<?php include 'header.php'; ?>
    <div id="view_products">
    	<h1>Store Statistics</h1>
        <h2>Order Totals:</h2>
        <table width="100%" border="1">
          <tr>
            <td><h1>Order Status</h1></td>
            <td><h1>Today</h1></td>
            <td><h1>This Week</h1></td>
            <td><h1>This Month</h1></td>
            <td><h1>This Year</h1></td>
            <td><h1>All Time</h1></td>
          </tr>
          <tr>
            <td><p>Pending</p></td>
            <td><p>$<?php echo $today = today('Pending'); ?></p></td>
            <td><p>$<?php echo $this_week = this_week('Pending'); ?></p></td>
            <td><p>$<?php echo $this_month = this_month('Pending'); ?></p></td>
            <td><p>$<?php echo $this_year = this_year('Pending'); ?></p></td>
            <td><p>$<?php echo $all_time = all_time('Pending'); ?></p></td>
          </tr>
          <tr>
            <td><p>Completed</p></td>
            <td><p>$<?php echo $today = today('Completed'); ?></p></td>
            <td><p>$<?php echo $this_week = this_week('Completed'); ?></p></td>
            <td><p>$<?php echo $this_month = this_month('Completed'); ?></p></td>
            <td><p>$<?php echo $this_year = this_year('Completed'); ?></p></td>
            <td><p>$<?php echo $all_time = all_time('Completed'); ?></p></td>
          </tr>
        </table><br /><br /><hr class="style-one" style="clear:both"></hr><br />
        <h2>Recent Orders:</h2>
        <table width="100%" border="1">
          <tr>
          	<td><h1>Sr#</h1></td>
            <td><h1>Name</h1></td>
            <td><h1>Total Qty.</h1></td>
            <td><h1>Total Amount</h1></td>
          </tr>
		  <?php list($name, $quantity, $amount) = recently_sold();
          for ($i = 0; $i < count($name); $i++) { ?>
          <tr>
          	<td><p><?php echo $i + 1 ?></p></td>
            <td><p><?php echo $name[$i] ?></p></td>
            <td><p><?php echo $quantity[$i] ?></p></td>
            <td><p>$<?php echo $amount[$i] ?></p></td>
          </tr>
          <?php
		  }
		  ?>
        </table>


	</div>
	<div class="clear"></div>
	<div id="footer">
		<p>All rights reserved by Smart Store</p>
	</div>
</body>
</html>