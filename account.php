<?php 
include 'init.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
	if ($_GET['id'] == 'post_ad') {
		$page = 'post_ad.php';
		echo '<style type="text/css">
        #three{
			background-color: #cecece; color:black;
		}
        </style>';
	} else if ($_GET['id'] == 'inbox') {
		$page = 'inbox.php';
		echo '<style type="text/css">
        #two{
			background-color: #cecece; color:black;
		}
        </style>';
	} else if ($_GET['id'] == 'delete_ads') {
		$page = 'delete_ads.php';
		echo '<style type="text/css">
        #four{
			background-color: #cecece; color:black;
		}
        </style>';
	} else if ($_GET['id'] == 'ps_info') {
		$page = 'ps_info.php';
		echo '<style type="text/css">
        #five{
			background-color: #cecece; color:black;
		}
        </style>';
	} else if ($_GET['id'] == 'change_password') {
		$page = 'change_password.php';
		echo '<style type="text/css">
        #six{
			background-color: #cecece; color:black;
		}
        </style>';
	} else if ($_GET['id'] == 'order_history') {
		$page = 'order_history.php';
		echo '<style type="text/css">
        #one{
			background-color: #cecece; color:black;
		}
        </style>';
	}
} else {
	header('Location:account.php?id=inbox');
	exit();
}

$sql = mysql_query("SELECT count(id) FROM private_messages where to_id='$session_user_id' AND opened='0'");
	$productCount = @mysql_num_rows($sql); // count the output amount
	if ($productCount > 0) {
		$count = mysql_fetch_row($sql);
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
                    	<div class="left_side">
                        	<div class="nothing">
                            	<h2>My Account</h2>
                                <table width="90%" border="1">
                                 <tr>
                                   <td><h1>ORDERS</h1><a href="?id=order_history"><li id="one">Order History</li></a></td>
                                  </tr>
                                  <tr>
                                    <td><h1>MY STUFF</h1>
                                    	<a href="?id=inbox"><li id="two">My Inbox (<?php echo $count[0] ?> new)</li></a>
                                        <a href="?id=post_ad"><li id="three">Post an ad</li></a>
                                        <a href="?id=delete_ads"><li id="four">Manage ads</li></a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><h1>SETTINGS</h1>
                                        <a href="?id=ps_info"><li id="five">Personal Information</li></a>
                                        <a href="?id=change_password"><li id="six">Change password</li></a>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        <div class="right_side">
                        	<div class="nothing">
                        		<?php 
								if (isset($page)) {
									include $page;
								} else {
									echo 'no';
								}
								?>
                                
							</div>
                        </div>
                    	<div class="clear"></div>
                    </div>
				</div>
		</div>
        <div class="footer">
			<?php include 'includes/footer.php'; ?>
		</div>
	</div>
</body>
</html>
