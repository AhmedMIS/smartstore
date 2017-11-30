<?php include 'product_query.php';
$limit = "LIMIT 6";
$array = menu_products('mobile', $limit); ?>
<ul id="dc_mega-menu-orange" class="dc_mm-orange">
		<li><a href="index.php">Home</a></li>
		<li><a href="products.php?category=electronics">Electronics</a>
			<ul>
				<li><a href="brand.php?subcategory=mobile">Mobile Phones</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=mobile"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
                <?php unset($array); $array = menu_products('Television', $limit); ?>
				<li><a href="brand.php?subcategory=television">Television</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=television"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
                <?php unset($array); $array = menu_products('laptop', $limit); ?>
				<li><a href="brand.php?subcategory=laptop">Laptop</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=laptop"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
                <?php unset($array); $array = menu_products('Camera', $limit); ?>
				<li><a href="brand.php?subcategory=camera">Camera</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=camera"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
			</ul>
		</li>
        
		<li><a href="products.php?category=Software">Software</a>
			<ul>
				<?php unset($array); $array = menu_products('Anti Virus', $limit); ?>
				<li><a href="brand.php?subcategory=Anti Virus">Anti Virus</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=Anti Virus"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
				<?php unset($array); $array = menu_products('Operating System', $limit); ?>
				<li><a href="brand.php?subcategory=Operating System">Operating System</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=Operating System"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="products.php?category=Home%26Kitchen">Home & Kitchen</a>
			<ul>
				<?php unset($array); $array = menu_products('Air Conditioner', $limit); ?>
				<li><a href="brand.php?subcategory=Air Conditioner">Air Conditioner</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=Air Conditioner"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
                <?php unset($array); $array = menu_products('Microwave Oven', $limit); ?>
                <li><a href="brand.php?subcategory=Microwave Oven">Microwave Oven</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=Microwave Oven"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>
                <?php unset($array); $array = menu_products('Refrigerator', $limit); ?>
                <li><a href="brand.php?subcategory=Refrigerator">Refrigerator</a>
					<ul><?php
					for ($i = 0; $i < count($array); $i++) {?>
						<li><a href="brand_name.php?brand=<?php echo $array[$i] ?>&subcategory=Refrigerator"><?php echo $array[$i] ?></a></li>
                    <?php } ?>
					</ul>
				</li>

			</ul>
		</li>
		<li><a href="about.php">About</a></li>
		<li><a href="faq.php">FAQ's</a></li>
        <li><a href="ads/" target="_blank">Customer Ads</a></li>
		<div class="clear"></div>
	</ul>