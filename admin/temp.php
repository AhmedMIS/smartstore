<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
	$message = 'Specifications were successfully added.';
}

?>

<?php include 'header.php'; ?>
        <div id="add_product">
        	<h1><?php echo $message ?></h1>
		</div>
        <div class="clear"></div>
        <div id="footer">
        	<p>All rights reserved by Smart Store</p>
        </div>
	</div>
</body>
</html>