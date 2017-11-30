
	<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			<?php
			if (logged_in() === false) {
			?>
                <div class="login">
                   <span><a href="login.php"><font color=#0000>Login</font></a></span>
				</div>
				<div class="login">
                   <span><a href="register.php"><font color=#0000>Signup</font></a></span>
				</div>
			   <?php
			   } else {
			   ?>	
					<div class="currency" title="currency">
						<div id="currency" class="wrapper-dropdown" style="width:150px;float:right;"tabindex="1">Hi, <?php echo $user_data['username']; ?>
							<strong class="opencart"> </strong>
							<ul class="dropdown">
								<li><a href="account.php?id=inbox">Account</a></li>
								<li><a href="logout.php" <?php if (!empty($_SESSION["cart_array"])) {?>onclick="return confirm('Shopping Cart will empty!');"<?php }?>>Logout</a></li>
							</ul>
						</div>
							<script type="text/javascript">
			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}

			$(function() {

				var dd = new DropDown( $('#currency') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown').removeClass('active');
				});

			});

							</script>
					</div>	 
			  <?php
			  }
			  ?>
			  <div class="header_top_right">
              <script TYPE="text/javascript">
$(document).ready(function() {

    $("#name option").filter(function() {
        return $(this).val() == $("#search").val();
    }).attr('selected', true);

    $("#name").live("change", function() {

        $("#search").val($(this).find("option:selected").attr("value"));
    });
});
</script>
			    <div class="search_box">
				    <form action="search.php" method="post" onSubmit="if (this.search.value == 'Search for Products' || this.pwd.value == '') {return false;}">
				    	<input type="text" id="search" name="search" value="Search for Products" maxlength="30" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}">
                        <input type="submit" value="SEARCH">
				    </form>
			    </div>
			    <div class="shopping_cart">
					<div class="cart">
						<a href="cart.php" title="View my shopping cart" rel="nofollow">
							<strong class="opencart"> </strong>
								<span class="cart_title">Cart (
								<?php
								if(isset($_SESSION['cart_array']))
								$items = count($_SESSION['cart_array']);
								else
								$items = 0;
								if($items == 1)
								$i = 'item';
								else
								$i = 'items';
								echo $items . ' ' . $i . ' )';
								?>
                                </span>
									<span class="no_product"></span>
							</a>
						</div>
			      </div>
<!--	    <div class="languages" title="language">
	    	<div id="language" class="wrapper-dropdown" tabindex="1">EN
						<strong class="opencart"> </strong>
						<ul class="dropdown languges">					
							 <li>
							 	<a href="#" title="Français">
									<span><img src="web/images/gb.png" alt="en" width="26" height="26"></span><span class="lang">English</span>
								</a>
							 </li>
								<li>
									<a href="#" title="Français">
										<span><img src="web/images/au.png" alt="fr" width="26" height="26"></span><span class="lang">Français</span>
									</a>
								</li>
						<li>
							<a href="#" title="Español">
								<span><img src="web/images/bm.png" alt="es" width="26" height="26"></span><span class="lang">Español</span>
							</a>
						</li>
								<li>
									<a href="#" title="Deutsch">
										<span><img src="web/images/ck.png" alt="de" width="26" height="26"></span><span class="lang">Deutsch</span>
									</a>
								</li>
						<li>
							<a href="$" title="Russian">
								<span><img src="web/images/cu.png" alt="ru" width="26" height="26"></span><span class="lang">Russian</span>
							</a>
						</li>					
				   </ul>
		     </div>
 -->		     <script type="text/javascript">
			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}

			$(function() {

				var dd = new DropDown( $('#language') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown').removeClass('active');
				});

			});

		</script>
		 </div>
			
		 <div class="clear"></div>
	 </div>
	 <div class="clear"></div>