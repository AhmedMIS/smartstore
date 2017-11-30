<?php

if (isset($_POST['submit'])) {
	$title			= test_input($_POST['title']);$title	= implode(" ",$title);
	$description	= test_input($_POST['description']);$description	= implode(" ",$description);
	$brand			= test_input($_POST['brand']);$brand	= implode(" ",$brand);
	$price			= test_input($_POST['price']);$price	= implode(" ",$price);
	$category		= $_POST['category'];
	$allowed_ext = array("gif", "jpeg", "jpg", "png");	
	
	if (empty($title)) {
		$errors[] = 'Title can not be empty.';
		echo '<style type="text/css">
        #title{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($price)) {
		$errors[] = 'Price can not be empty.';
		echo '<style type="text/css">
        #price{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($_POST['category'])) {
		$errors[] = 'Category can not be empty.';
		echo '<style type="text/css">
        #category{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($_POST['subcategory'])) {
		$errors[] = 'Subcategory can not be empty.';
		echo '<style type="text/css">
        #subcategory{
			border:1px solid red;
		}
        </style>';
	} else {
		$subcategory	= $_POST['subcategory'];	
	}
	if (empty($brand)) {
		$errors[] = 'Brand can not be empty.';
		echo '<style type="text/css">
        #brand{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($description)) {
		$errors[] = 'Description can not be empty.';
		echo '<style type="text/css">
        #description{
			border:1px solid red;
		}
        </style>';
	}
	if (empty($_FILES['fileField1']['name'])) {
		$errors[] = 'Image 1 not selected.';
		echo '<style type="text/css">
        #fileField1{
			border:1px solid red;
		}
        </style>';
	} else {
		$image_name_1	= $_FILES['fileField1']['name'];
		$image_size_1	= $_FILES['fileField1']['size'];
		$extension_1	= strtolower(end(explode(".", $image_name_1)));
		if (!in_array($extension_1, $allowed_ext)) {
			$errors[] = 'File type "'. $image_name_1 .'" not allowed.';
		} else {
			if (@empty(getimagesize($_FILES["fileField1"]["tmp_name"]))) {
				$errors[] =  '"' . $image_name_1 . '" is not an image file.';
			}
		}
		if ($image_size_1 > 3388608) {
			$errors[] = '"' . $image_name_1 . '" exceeds file size 3 MB.';
		}
	}
	if (empty($_FILES['fileField2']['name'])) {
		$errors[] = 'Image 2 not selected.';
		echo '<style type="text/css">
        #fileField2{
			border:1px solid red;
		}
        </style>';
	} else {
		$image_name_2	= $_FILES['fileField2']['name'];
		$image_size_2	= $_FILES['fileField2']['size'];
		$extension_2	= strtolower(end(explode(".", $image_name_2)));
		if (!in_array($extension_2, $allowed_ext)) {
			$errors[] = 'File type "'. $image_name_2 .'" not allowed.';
		} else {
			if (@empty(getimagesize($_FILES["fileField2"]["tmp_name"]))) {
				$errors[] =  '"' . $image_name_2 . '" is not an image file.';
			}
		}
		if ($image_size_2 > 3388608) {
			$errors[] = '"' . $image_name_2 . '" exceeds file size 3 MB.';
		}
	}
	if (empty($_FILES['fileField3']['name'])) {
		$errors[] = 'Image 3 not selected.';
		echo '<style type="text/css">
        #fileField3{
			border:1px solid red;
		}
        </style>';
	} else {
		$image_name_3	= $_FILES['fileField3']['name'];
		$image_size_3	= $_FILES['fileField3']['size'];
		$extension_3	= strtolower(end(explode(".", $image_name_3)));
		if (!in_array($extension_3, $allowed_ext)) {
			$errors[] = 'File type "'. $image_name_3 .'" not allowed.';
		} else {
			if (@empty(getimagesize($_FILES["fileField3"]["tmp_name"]))) {
				$errors[] =  '"' . $image_name_3 . '" is not an image file.';
			}
		}
		if ($image_size_3 > 3388608) {
			$errors[] = '"' . $image_name_3 . '" exceeds file size 3 MB.';
		}
	}

	if (empty($errors)) {
		$id			= $_SESSION["user_id"];
		$location	= mysql_query("SELECT city FROM users WHERE user_id='$id'");
		$productCount = @mysql_num_rows($location);
		if ($productCount > 0) {
			while($row	= mysql_fetch_array($location)){
				$city 	= $row['city']; 
			}
		}
		$sql		= mysql_query("INSERT INTO ads (`user_id`,`title`,`price`,`description`,`category`,`subcategory`,`brand`,`date_added`,`city`) VALUES ('$id','".addslashes($title)."','$price','".addslashes($description)."','$category','$subcategory','".addslashes($brand)."',now(),'$city')");
		$ad_id		= mysql_insert_id();
		$directory	='../admin/inventory_images/ads/' . $id;
		if (!is_dir($directory))
		mkdir('../admin/inventory_images/ads/' . $id, 0744);
		mkdir('../admin/inventory_images/ads/' . $id . '/' . $ad_id, 0744);
		move_uploaded_file( $_FILES['fileField1']['tmp_name'], "../admin/inventory_images/ads/" . $id . "/" . $ad_id .  "/$ad_id.jpg");
		move_uploaded_file( $_FILES['fileField2']['tmp_name'], "../admin/inventory_images/ads/" . $id . "/" . $ad_id . "/$ad_id" . "_1" . ".jpg");
		move_uploaded_file( $_FILES['fileField3']['tmp_name'], "../admin/inventory_images/ads/" . $id . "/" . $ad_id . "/$ad_id" . "_2" . ".jpg");
		$message = '<h2>Your ad was successfully posted.</h2>';

	}
}

?>

<script type='text/javascript'>
var counter = 1;
var limit = 3;
function populate(s1,s2){
	var s1 = document.getElementById(s1);
	var s2 = document.getElementById(s2);
	s2.innerHTML = "";
	if(s1.value == "Mobile & Tablets"){
		var optionArray = ["|","Mobile Phones|Mobile Phones","Tablets|Tablets","Mobile Accessories|Mobile Accessories"];
	} else if(s1.value == "Electronics & Computers"){
		var optionArray = ["|", "Computers, Laptops, Accessories|Computers, Laptops, Accessories", "CD-DVD|CD-DVD", "Camera & Accessories|Camera & Accessories","Video games & Consoles|Video games & Consoles","Tv|Tv","Other Electronics|Other Electronics"];
	} else if(s1.value == "Vehicles"){
		var optionArray = ["|", "Cars|Cars", "Motorcycles|Motorcycles", "Scooters|Scooters","Bicycles|Bicycles","Commercial Vehicles|Commercial Vehicles","Spare parts & Accessories|Spare parts & Accessories","Other Vehicles|Other Vehicles"];
	} else if(s1.value == "Home & Furniture"){
		var optionArray = ["|","Furniture|Furniture","Decor & Furnishing|Decor & Furnishing", "Fridge - AC - Washing Machine|Fridge - AC - Washing Machine", "Home & Kitchen Appliances|Home & Kitchen Appliances", "Paintings & Handicrafts|Paintings & Handicrafts","Other Household Items|Other Household Items.."];
	} else if(s1.value == "Books Sports & Hobbies"){
		var optionArray = ["|", "Books & Magazines|Books & Magazines", "Musical Instruments|Musical Instruments", "Sports Equipment|Sports Equipment","Gym & Fitness|Gym & Fitness","Coins & Collectables|Coins & Collectables","Other Hobbies|Other Hobbies"];
	} else if(s1.value == "Animals"){
		var optionArray = ["|", "Dogs|Dogs", "Aquariums|Aquariums", "Birds|Birds","Cats|Cats","Pet Food|Pet Food","Other Animals|Other Animals"];
	}
	 else if(s1.value == "Fashion & Beauty"){
		var optionArray = ["|", "Clothes|Clothes", "Footwear|Footwear", "Jewellery|Jewellery","Bags & Luggage|Bags & Luggage","Accessories|Accessories","Watches|Watches","Health & Beauty|Health & Beauty"];
	}
	 else if(s1.value == "Kids & Baby Products"){
		var optionArray = ["|", "Strollers|Strollers", "Kids Furniture|Kids Furniture", "Carriers - Rockers|Carriers - Rockers","Nutrition|Nutrition","Clothes & Footwear|Clothes & Footwear","Toys & Games|Toys & Games", "Other Kid Items|Other Kid Items"];
	}
	 else if(s1.value == "Services"){
		var optionArray = ["|", "Education & Classes|Education & Classes", "Web Development|Web Development", "Electronics Repair|Electronics Repair","Maids & Domestic Help|Maids & Domestic Help","Movers & Packers|Movers & Packers","Drivers - Taxi|Drivers - Taxi", "Event Services|Event Services", "Other Services|Other Services"];
	}
	 else if(s1.value == "Jobs"){
		var optionArray = ["|", "Customer Service|Customer Service", "IT|IT", "Online|Online","Marketing|Marketing","Advertising|Advertising","Sales|Sales","Human Resources|Human Resources","Hotels & Tourism|Hotels & Tourism","Accounting & Finance|Accounting & Finance","Manufacturing|Manufacturing","Part Time|Part Time","Other Jobs|Other Jobs"];
	} else if(s1.value == "Real Estate"){
		var optionArray = ["|", "Houses|Houses", "Apartments|Apartments", "Land - Plots|Land - Plots","Shops - Offices|Shops - Offices","Rental Houses|Rental Houses"];
	}
	for(var option in optionArray){
		var pair = optionArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		s2.options.add(newOption);
	}
}

</script>
<div class="description">
<?php if (isset($message)) echo $message; else {?>
<p>All Mandatory fields</p><br>
<?php if (!empty($errors))  foreach($errors as $error) echo"<p>&#9658 ". $error ."</p>"?>


<table width="100%">
	<form action="" method="post" enctype="multipart/form-data">
		<tr>
			<td><h2>Title:</h2></td>
			<td style="border-right:none"><input type="text" name="title" id="title" value="<?php if (isset($title)) echo $title ?>" maxlength="45" /></td>
		</tr>
		<tr>
			<td><h2>Price:</h2></td>
			<td style="border-right:none"><input type="text" name="price" id="price" value="<?php if (isset($price)) echo $price ?>" maxlength="7" onkeypress="return isNumberKey(event)" /></td>
		</tr>
		<tr>
			<td><h2>Category:</h2></td>
			<td style="border-right:none">
				<select name="category" id="category" style="width:auto;" onchange="populate(this.id,'subcategory');">
					<option value=""></option>
					<option value="Mobile & Tablets">Mobile & Tablets</option>
					<option value="Electronics & Computers">Electronics & Computers</option>
					<option value="Vehicles">Vehicles</option>
                    <option value="Home & Furniture">Home & Furniture</option>
                    <option value="Animals">Animals</option>
                    <option value="Books Sports & Hobbies">Books Sports & Hobbies</option>
                    <option value="Fashion & Beauty">Fashion & Beauty</option>
                    <option value="Services">Services</option>
                    <option value="Jobs">Jobs</option>
                    <option value="Real Estate">Real Estate</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><h2>Sub-category:</h2></td>
			<td style="border-right:none">
				<select name="subcategory" id="subcategory"></select>
			</td>
		</tr>
		<tr>
			<td><h2>Brand:</h2></td>
			<td style="border-right:none"><input type="text" name="brand" id="brand" maxlength="15" ></td>
		</tr>        
		<tr>
			<td><h2>Description:</h2></td>
			<td style="border-right:none"><textarea name="description" id="description" rows="5" cols="50" onkeypress="if (this.value.length > 300) { return false; }" /><?php if (isset($description)) echo $description ?></textarea></td>
		</tr>
        <tr>
			<td><h2>Image 1:</h2></td>
			<td style="border-right:none;">
				<input type="file" name="fileField1" id="fileField1" accept="image/*" />
			</td>
		</tr>
		<tr>
			<td><h2>Image 2:</h2></td>
			<td style="border-right:none;">
				<input type="file" name="fileField2" id="fileField2" accept="image/*" />
			</td>
		</tr>
		<tr>
			<td><h2>Image 3:</h2></td>
			<td style="border-right:none;">
				<input type="file" name="fileField3" id="fileField3" accept="image/*" />
			</td>
		</tr>
		<tr>
			<td style="border:none"></td>
			<td style="border:none"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</form>
</table><?php }?>
</div>
<SCRIPT language=Javascript>
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</SCRIPT>
