<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; 
if (isset($_GET['id']) && !empty($_GET['id'])) {
	if ($_GET['id'] == 'inbox') {
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
	}
} else {
	header('Location:account.php?id=ps_info');
	exit();
}

?>
<script type="text/javascript">
function tab(tab) {
document.getElementById('tab1').style.display = 'none';
document.getElementById('tab2').style.display = 'none';
document.getElementById('tab3').style.display = 'none';
document.getElementById('tab4').style.display = 'none';
document.getElementById('li_tab1').setAttribute("class", "");
document.getElementById('li_tab2').setAttribute("class", "");
document.getElementById('li_tab3').setAttribute("class", "");
document.getElementById('li_tab4').setAttribute("class", "");
document.getElementById(tab).style.display = 'block';
document.getElementById('li_'+tab).setAttribute("class", "active");
}
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	  return false;
	return true;
}
</script>
</head>
<body>
	<div id="wrapper">
    	<?php include 'header.php' ?>
        <div id="Tabs">
			<ul>
				<li id="li_tab1" onclick="tab('tab1')" ><a href="?id=ps_info"><p>Personal Details</p></a></li>
				<li id="li_tab2" onclick="tab('tab2')"><a href="?id=change_password"><p>Change Password</p></a></li>
                <li id="li_tab3" onclick="tab('tab3')"><a href="?id=inbox"><p>Messages</p></a></li>
                <li id="li_tab4" onclick="tab('tab4')"><a href="?id=delete_ads"><p>Manage Ads</p></a></li>
			</ul>
			<div id="Content_Area">
				<div id="tab1">
                	<?php if (isset($page))include $page; else echo 'no' ?>
                </div>
				<div id="tab2" style="display: none;">
                	<?php if (isset($page))include $page; else echo 'no' ?>
                </div>
                <div id="tab3" style="display: none;">
                	<?php if (isset($page))include $page; else echo 'no' ?>
                </div>
                <div id="tab4" style="display: none;">
                	<?php if (isset($page))include $page; else echo 'no' ?>
                </div>
            </div>
		</div>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>	</div>
</body>
</html>

