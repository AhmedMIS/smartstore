<?php
include 'init.php';

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user tries to add something to the cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	//if the cart session variable is not set or cart array is empty
	if (!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
		//RUN IF THE CART IS EMPTY OR NOT SET
		$_SESSION['cart_array'] = array(0 => array('item_id' => $pid, 'quantity' => 1));
	} else {
		//RUN IF THE CART HAS ATLEAST ONE ITEM
		foreach ($_SESSION['cart_array'] as $each_item) {
			$i++;
			while (list($key, $value) = each($each_item)) {
				if ($key == 'item_id' && $value == $pid) {
					//THAT ITEM IS IN CART ALREADY SO ADJUST ITS QUANTITY USING ARRAY_SPLICE
					array_splice($_SESSION['cart_array'], $i - 1, 1, array(array('item_id' => $pid, 'quantity' => $each_item['quantity'] + 1)));
					$wasFound = true;
				}//end if
			}//end while
		}//end foreach
		if ($wasFound == false) {
			array_push($_SESSION['cart_array'], array('item_id' => $pid, 'quantity' => 1));
		}
	}
	if (logged_in() === false){
		$_SESSION['redirect'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		header('Location: login.php');
		exit();
	} 
	header('Location:cart.php');
	exit();
} 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
	unset($_SESSION['pid']);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != '') {
	$item_to_adjust	= $_POST['item_to_adjust'];
	if (empty($_POST['quantity']) || $_POST['quantity'] > 9) {
		$quantity = 1;
	} else {
		$quantity = $_POST['quantity'];
	}
	
	$i = 0;
	foreach ($_SESSION['cart_array'] as $each_item) {
		$i++;
		while (list($key, $value) = each($each_item)) {
			if ($key == 'item_id' && $value == $item_to_adjust) {
				//THAT ITEM IS IN CART ALREADY SO ADJUST ITS QUANTITY USING ARRAY_SPLICE
				array_splice($_SESSION['cart_array'], $i - 1, 1, array(array('item_id' => $item_to_adjust, 'quantity' => $quantity)));
			}//end if
		}//end while
	}//end foreach

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from the cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != '') {
	//ACCESS THE ARRAY AND RUN THE CODE TO REMOVE THAT ARRAY INDEX
	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION['cart_array']) <= 1) {
		unset($_SESSION['cart_array']);
	} else {
		unset($_SESSION['cart_array']["$key_to_remove"]);
		sort($_SESSION['cart_array']);
		
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5 (render the cart for the user to view)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = '';
$cartTotal = 0;
$pp_checkout_btn = '';
$product_id_array = '';
$empty = false;
if (!isset($_SESSION['cart_array']) || count($_SESSION['cart_array']) < 1) {
		//RUN IF THE CART IS EMPTY OR NOT SET
		unset($_SESSION['pid']);
		$cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
		$empty = true;
} else {
	// Start PayPal Checkout Button
	$pp_checkout_btn .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="softiron_pc@yahoo.com">';
	// Start the For Each loop
	$i = 0;
	foreach ($_SESSION['cart_array'] as $each_item) {
		
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM products WHERE `id`='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name	= $row['product_name'];
			$price			= $row['price'];
			$details		= $row['details'];
		}
		$price = number_format($price, 2, '.', '');
		$price_total = $price * $each_item['quantity'];
		$price_total = number_format($price_total, 2, '.', '');
		$cartTotal = $price_total + $cartTotal;
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;
		$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].",";

		//Dynamic table row assembly
		$cartOutput .= '<tr>';
		$cartOutput .= '<td><br><p><a href="preview.php?id=' . $item_id . '">' . $product_name . '</a><p><img src="admin/inventory_images/products/' . $item_id . '/' . $item_id . '.jpg" alt="' . $product_name . '" width="auto" height="80px" border="1"></td>';
		$cartOutput .= '<td><br><p>' . $details . '</p></td>';
		$cartOutput .= '<td><br><p>$' . $price . '</p></td>';
		$cartOutput .= '<td><br><p>
						<form action="cart.php" method="post">
						<input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="1" onkeypress="return isNumberKey(event)" />
						<input name="adjustBtn ' . $item_id . '" type="submit" value="Change" />
						<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
						</form></p></td>';
		$cartOutput .= '<td><br><p>$' . $price_total . '</p></td>';
		$cartOutput .= '<td><br>
						<form action="cart.php" method="post">
						<input name="deleteBtn ' . $item_id . '" type="submit" value="Remove" />
						<input name="index_to_remove" type="hidden" value="' . $i . '" />
						</form></td>';
		$cartOutput .= '</tr>';
		$i++;
	}
	$cartTotal = number_format($cartTotal, 2);
	$cartTotal = "<p>Cart Total: $" . $cartTotal.'</p>';
		    // Finish the Paypal Checkout Btn
			$_SESSION['pid'] = rtrim($product_id_array, ",");
			$_SESSION['total'] = $price_total;
	$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	<input type="hidden" name="notify_url" value="http://localhost:81/smart-store/my_ipn.php">
	<input type="hidden" name="return" value="http://localhost:81/smart-store/checkout_complete.php">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" name="cancel_return" value="http://localhost:81/smart-store/cancel.php">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="currency_code" value="USD">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
	</form> or<br><a href="cash_on_delivery.php">Cash on delivery</a>';

}

?>
<head>
<title>Smart Store</title>
<?php include 'includes/head.php';?>
<SCRIPT language=Javascript>
function MyFunction() {
	document.getElementById('cash_on_delivery').submit();
}
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</SCRIPT>

</head>
<body>
	<div class="wrap">
		<div class="header">
			<?php include 'includes/header.php'; ?>
		</div>
		<div class="menu">
			<?php include 'includes/menu.php'; ?>
		</div>
		<div class="header_bottom">
		
			<div class="main">
				<div class="content">
					<div class="table">
						<?php 
                        if ($empty == false) {
                        ?>
                        <table width="100%" border="1" cellspacing="0" cellpadding="6">
                          <tr id ="table_cart">
                            <td width="23%" bgcolor="#C5DFFA"><strong>Product</strong></td>
                            <td width="35%" bgcolor="#C5DFFA"><strong>Product Description</strong></td>
                            <td width="12%" bgcolor="#C5DFFA"><strong>Unit Price</strong></td>
                            <td width="12%" bgcolor="#C5DFFA"><strong>Quantity</strong></td>
                            <td width="11%" bgcolor="#C5DFFA"><strong>Total</strong></td>
                            <td width="7%" bgcolor="#C5DFFA"><strong>Remove</strong></td>
                          </tr>
                         <?php
                         echo $cartOutput;
                            } else {
                                echo $cartOutput;
                            }
                            ?>
                        </table>
   
						   <?php 
                           if ($empty == false) {
                               
                           ?>
					
                        <table width="100%" border="1">
                            <tr>
                                <td width="82%" style="text-align:left; border:none;"><a href="cart.php?cmd=emptycart"><u>Empty</u></a> Shopping Cart<br><br></td>
                                <td width="20%"><div style="font-weight:bold;"><?php echo $cartTotal ?></div></td>
                            </tr>
                            <tr>
                                <td style="border:none;"></td>
                                <td><?php echo $pp_checkout_btn; ?></td>
                            </tr>
                        </table>
                    <?php }?>
        </div>
					<div class="clear">
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
   	  <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>

