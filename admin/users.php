<?php 
include '../init.php';
include '../includes/product_query.php';
if (logged_admin() === false) {
	header('Location: login.php');
	exit();
}
list($user_id, $username, $first_name, $email, $contact, $city) = all_users();

?>
	<?php include 'header.php'; ?>
		<div id="users">
    		<h1>Registered Users:</h1>
            <table width="100%" border="1">
              <tr>
                <td><h1>User ID</h1></td>
                <td><h1>Username</h1></td>
                <td><h1>First Name</h1></td>
                <td><h1>Email</h1></td>
                <td><h1>Contact</h1></td>
                <td><h1>City</h1></td>
              </tr>
              <?php 
              for ($i = 0; $i < count($user_id); $i++) {
				  ?>
              <tr>
                <td><p><?php echo $user_id[$i] ?></p></td>
                <td><p><?php echo $username[$i] ?></p></td>
                <td><p><?php echo $first_name[$i] ?></p></td>
                <td><p><?php echo $email[$i] ?></p></td>
                <td><p><?php echo $contact[$i] ?></p></td>
                <td><p><?php echo $city[$i] ?></p></td>
              </tr>
              <?php
			  }
			  ?>
            </table>
    	</div><br /><br />
        <div id="users" style="width:39%;margin-top: -30px;">
        	<h1>User Report:</h1>
            <table width="100%" border="1">
              <tr>
                <td><h1>Customer</h1></td>
                <td><h1>Number of Orders</h1></td>
                <td><h1>Total Amount</h1></td>
              </tr>
              <tr><?php unset($user_id); $user_id = user_id_from_transactions();
				  for ($i = 0; $i < count($user_id); $i++) {
					?>
                <td><p><?php echo $username[$i]	= username($user_id[$i]) ?></p></td>
                <td><p><?php echo $count = count_from_transactions($user_id[$i]) ?></p></td>
                <td><p>$<?php echo $amount = amount_from_user_id($user_id[$i]) ?></p></td>
              </tr>
              <?php
			  }?>
            </table>

        </div>
		<div class="clear"></div>
        <div id="footer">
        	<p>All rights reserved by Smart Store</p>
        </div>
	</div>
</body>
</html>