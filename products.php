<!DOCTYPE HTML>
<head>
<?php 
include 'init.php';
include 'includes/head.php'; 

function exists_category($category) {
	$sql = mysql_query("SELECT id FROM products WHERE category='$category'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}


if (!isset($_GET['category']) && empty($_GET['category'])) {
	header('Location:page_not_found.php');
	exit();
} else
	if (exists_category($_GET['category']) === false) {
	header('Location:page_not_found.php');
	exit();
	}
	$category = $_GET['category'];

?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=810">
  <link rel="stylesheet" href="inc/prettify.css">
  <link rel="stylesheet" href="inc/microfiche.css">
  <link rel="stylesheet" href="inc/microfiche.demo.css">
  <script src="inc/jquery-1.7.1.js"></script>
  <script src="inc/prettify.js"></script>
  <script src="inc/microfiche.js"></script>
  <script type="text/javascript" src="http://fast.fonts.com/jsapi/b4bd1e58-b76c-41db-beda-55eac402a457.js"></script>
  <script language="javascript" type="text/javascript">
    function my_onkeydown_handler() {
    switch (event.keyCode) {
        case 116 : // 'F5'
            event.preventDefault();
            event.keyCode = 0;
            window.status = "F5 disabled";
            break;
		case 82 : //R button
            if (event.ctrlKey){ 
                event.preventDefault();
                event.keyCode = 0;
				window.status = "F5 disabled";
            }
			break;
    }
}
document.addEventListener("keydown", my_onkeydown_handler);
</script>


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
                	<div class="content_top">
                    	<div class="heading">
    						<h3>Feature Products</h3>
						</div>
    					<div class="clear"></div>
    				</div>
                    
                    <div class="section group">
                    	<div class="demo">
                        <?php list($array) = select_category($category); slider('default', $array);?>
							<script>example('default')</script>
							<script>$('#default').microfiche()</script>
                        </div>
                	</div>
                    <div class="content_bottom">
    					<div class="heading">
    						<h3>New Products</h3>
    					</div>
    					<div class="clear"></div>
                    </div>
                    
                    <div class="section group">
                    	<div class="demo">
                        <?php unset($array);list($array) = select_category_by_date($category); slider('cyclic', $array); ?>
							<script>example('cyclic')</script>
							<script>$('#cyclic').microfiche({ cyclic: false })</script>
                        </div>
					</div>
				</div>
            </div>
		</div>
		<div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
    </div>
</body>
</html>

