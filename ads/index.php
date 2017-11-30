<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'head.php'; ?>
</head>

<body>
	<div id="wrapper">
    <?php include 'header.php'; $category = get_category(); $dyn_table = ""?>
   
        <div id="category">
            <?php $dyn_table = '<table width="100%" border="0">'; ?>
            <?php for ($i = 0; $i < count($category); $i++) {
                    $row =	'<a href="categories.php?category='. urlencode($category[$i]) .'">
                        	<img src="images/'. $echo = str_replace(" ", "-", $category[$i]).'.png" />
                        	<h2>'. $category[$i] .'</h2>
                        </a>'; 
						if ($i % 3 == 0) {
							$dyn_table .='<tr><td>'.$row.'</td>';
						} else {
							$dyn_table .='<td>'.$row.'</td>';
						}
			}?><br>
             <?php $dyn_table .= '</tr></table></a>'; echo $dyn_table;?>
             
        </div>
    	<div id="footer">
        	<?php include 'footer.php'; ?>
        </div>
    </div>
</body>
</html>
