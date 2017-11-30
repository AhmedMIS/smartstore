<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Area</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script TYPE="text/javascript">
function populate(s1,s2){
	var s1 = document.getElementById(s1);
	var s2 = document.getElementById(s2);
	s2.innerHTML = "";
	if(s1.value == "Electronics"){
		var optionArray = ["|","laptop|Laptop","mobile|mobile","television|Television","camera|Camera"];
	} else if(s1.value == "Software"){
		var optionArray = ["|", "Anti Virus|Anti Virus", "Operating System|Operating System", "Office Tools|Office Tools"];
	} else if(s1.value == "Home&Kitchen"){
		var optionArray = ["|","Iron|Iron","Air Conditioner|Air Conditioner", "Washing Machine|Washing Machine", "Refrigerator|Refrigerator"];
	}
	for(var option in optionArray){
		var pair = optionArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		s2.options.add(newOption);
	}
}
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
		return true;
      }
function fun(id)
{
	var status = "change"+ id;
    if(document.getElementById("payment_status"+id).value=="Pending")
        document.getElementById(status).disabled=true;
    else
	document.getElementById(status).disabled=false;
}
function tab(tab) {
document.getElementById('tab1').style.display = 'none';
document.getElementById('tab2').style.display = 'none';
document.getElementById('li_tab1').setAttribute("class", "");
document.getElementById('li_tab2').setAttribute("class", "");
document.getElementById(tab).style.display = 'block';
document.getElementById('li_'+tab).setAttribute("class", "active");
}
</script>

</head>
<body>


	<div id="wrapper" style="background-color:#CCC">
    	<div id="header">
        	<a href="index.php"><h1>Admin Page</h1></a>
        	<ul>
        	  <!-- <li><a href="account.php">Account</a></li>-->
        	  <li><a href="logout.php">Logout</a></li>
			</ul>
        </div>
        <div class="clear"></div>
        <div id="menu">
        	<ul>
            	<li><a href="index.php">Dashboard</a></li>
               	<li><a href="#">Products &#9662;</a>
                	<ul>
                       	<li><a href="view_products.php">Manage Products</a></li>
                        <li><a href="add_product.php">Add Products</a></li>
                    </ul>
                </li>
                <li><a href="transactions.php">Sales</a></li>
                <li><a href="users.php">Customers</a></li>
            </ul>
        </div>