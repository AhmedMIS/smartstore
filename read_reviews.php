<?php
include 'init.php';

function exists_id($id) {
	$sql = mysql_query("SELECT id FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		return true;
	} else {
		return false;
	}
}

function exists_page($page, $id) {
	$per_page = 5;
	$pages_query	= mysql_query("SELECT count(id) FROM product_review WHERE product_id='$id'");
	$items			= mysql_result($pages_query, 0);
	$pages			= ceil(mysql_result($pages_query, 0) / $per_page);
	if ($_GET['page'] > $pages || $_GET['page'] < 0) {
		return false;
	} else {
		return true;
	}
}


function get_name($id) {
	$sql = mysql_query("SELECT product_name FROM products WHERE id='$id'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		while($row = mysql_fetch_array($sql))
		$product_name = $row['product_name'];
		return $product_name;
	} else {
		echo 'no';
		return false;
	}
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
	header('Location:page_not_found.php');
	exit();
} else {
	if (exists_id($_GET['id']) === false) {
		header('Location:page_not_found.php');
		exit();
	}
	if (isset($_GET['id']) && !empty($_GET['id'])) {
		if (preg_replace('#[^A-Za-z]#i', '', $_GET['id'])) {
    		header('Location:page_not_found.php');
			exit();
		}
		$product_name = get_name($_GET['id']);
		$id	= mysql_real_escape_string(htmlentities(trim($_GET['id'])));
	}
}
 if (!isset($_GET['page']) || empty($_GET['page'])) {
	header('Location:page_not_found.php');
	exit();
} else {
	if (exists_page($_GET['page'], $id) === false) {
		header('Location:page_not_found.php');
		exit();
	}
	if (isset($_GET['page']) && !empty($_GET['page'])) {
		if (preg_replace('#[^A-Za-z]#i', '', $_GET['page'])) {
    		header('Location:page_not_found.php');
			exit();
		}
		$page = $_GET['page'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Smart Store</title>
	<?php include 'includes/head.php';?>
</head>
<body>
	<div class="wrap">
    	<div class="header">
			<?php include 'includes/header.php'; ?>
            <div class="menu">
				<?php include 'includes/menu.php'; ?>
			</div>
            <div class="header_bottom">
            </div><div class="clear"></div>
            <div class="main">
				<div class="content">
                	<div class="content_top">
                    	<a href="preview.php?id=<?php echo $_GET['id'] ?>"><h4>BACK TO PRODUCT PAGE</h4></a>
                    </div>
                    <div class="content_bottom" style="width:90%; margin: 10px auto;">
                        <div class="product-tags">
                            <h2>REVIEWS OF <?php echo $product_name ?></h2>
                            <?php
							$pages_query	= mysql_query("SELECT count(id) FROM product_review WHERE product_id='$id'");
							$per_page		= 5;
							$items			= mysql_result($pages_query, 0);
							$pages			= ceil(mysql_result($pages_query, 0) / $per_page);
							$start			= ($page - 1) * $per_page; 
							$end			= $start + 5;
							if ($end > $items) {
								$end = $items;
							}
							$sql = mysql_query("SELECT * FROM product_review WHERE product_id='$id'");
							$productCount = @mysql_num_rows($sql); // count the output amount
							if ($productCount > 0) {
								$i = 0;
								while($row = mysql_fetch_array($sql)){
									$user_id[$i]	= $row['user_id'];
									$username[$i]	= username($user_id[$i]);
									$title[$i]		= $row['title'];
									$review[$i]		= $row['review'];
									$rating[$i]		= $row['rating'];
									$date_added[$i]	= $row['date_added'];
									$i = $i + 1;
									}
							} else echo 'no';
								if ($page == 1) {?>
                                	<h4>Showing Reviews 1 - <?php echo $end; ?> out of <?php echo count($title) ?></h4>
                                <?php
                                } else {?>
									<h4>Showing Reviews <?php echo $start + 1 ?> - <?php echo $end ?> out of <?php echo $items ?></h4>
								<?php }
                                for ($i = $start; $i < $end; $i++) {?>
                                <table width="90%" border="1">
                                    <tr>
                                        <td width="20%"><h1>Rating: <?php echo $rating[$i]?> / 5</h1></td>
                                        <td width="80%"><h1><?php echo $title[$i]?></h1></td>
                                    </tr>
                                    <tr>
                                        <td><p style="text-decoration:underline;"><?php echo $username[$i]?></p>
                                        <p><?php echo date_format(date_create_from_format('Y-m-d', $date_added[$i]), 'd-m-Y'); ?></p></td>
                                        <td><p><?php echo $review[$i]?></p></td>
                                    </tr>
                                </table><hr class="style-one"></hr><br>
                                <?php }
								if ($pages >= 1 && $page <= $pages) {
									for ($j =1; $j <= $pages; $j ++) {
										echo ($j == $page) ? '<a style="font-weight:bolder; text-decoration:underline;" href="?id='. $id .'&page=' . $j . '">' . $j . '</a> ':'<a href="?id='. $id .'&page=' . $j . '">' . $j . '</a>';
									}
								} ?>
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
