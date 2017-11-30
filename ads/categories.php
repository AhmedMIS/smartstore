<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php';
if (!isset($_GET['category']) || empty($_GET['category']) || exists_category(urldecode($_GET['category'])) === false) {
	header('Location:categories.php?category=Mobile+%26+Tablets');
	exit();
}
?>
</head>

<body>
	<div id="wrapper">
    	<?php include 'header.php'; $dyn_table = ""?>
        <div id="main_categories">
            <table>
            	<h2>Main Categories:</h2>
              <?php $category = get_category();
			  for ($i = 0; $i < count($category); $i++) {?>
              <tr>
                <td><a href="?category=<?php echo urlencode($category[$i]) ?>"><li><strong><?php echo $category[$i] ?></strong></li></a></td>
              </tr>
              <?php }?>
            </table>
        </div>
        <div id="subcategories">
            <table>
              <tr>
                <td><img src="images/<?php echo $echo = str_replace(" ", "-", $_GET['category']) ?>.png" /></td>
                <td>
					<h2><?php echo urldecode($_GET['category']) ?></h2>
                    <p><?php echo $count = count_ads(urldecode($_GET['category'])); ?> ads</p>
                    <p><a href="results.php?search=<?php echo urlencode($_GET['category']) ?>">View All >></a></p>
                </td>
              </tr>
            </table>
            <div class="sub">
				<?php 
				$dyn_table = '<table width="100%">';
				$id = get_id_from_category(urlencode($_GET['category'])); $subcategory = get_subcategory($id);
				for ($i = 0; $i < count($subcategory); $i++) {
					$row = '<a href="results.php?search='. urlencode($subcategory[$i]) .'"><img src="images/'. $echo = str_replace(" ", "-", $subcategory[$i]) .'.png" /><p>'.$subcategory[$i].'</p></a>';
                    
                    if ($i % 4 == 0) {
                        $dyn_table .='<tr><td>'.$row.'</td>';
                    } else {
                        $dyn_table .='<td>'.$row.'</td>';
                    }
				}
				$dyn_table .= '</tr></table></a>'; echo $dyn_table;
				?>
              </div>

        </div>
        <div class="clear"></div>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>
	</div>
</body>
</html>
