
<div id="header">
    <table width="100%" border="0">
        <tr><?php if (logged_in() === false) { ?>
            <td width="77%"><a href="index.php"><h1>Smart Sale</h1></a></td>
            <td width="10%" align="center"><a href="register.php"><h2>Sign up</h2></a></td>
            <td width="13%" align="center"><a href="login.php"><h2>Log in</h2></a></td>
            <?php
        } else {?>
            <td width="77%"><a href="index.php"><h1>Smart Sale</h1></a></td>
            <td width="10%" align="center"><a href="account.php"><h2>Account</h2></a></td>
            <td width="13%" align="center"><a href="logout.php"><h2>Log out</h2></a></td>
            <?php
        }?>
        </tr>
        <tr>
            <form action="search_ads.php" method="post" onSubmit="if (this.search_ads.value == 'Search for Products' || this.pwd.value == '') {return false;}">
            <td align="right"><input type="text" name="search_ads" id="search_ads" size="70" maxlength="30" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}" /></td>
            <td><input type="submit" name="submit" value="Search" /></td>
            <td align="center"><a href="submit_ad.php"><h2>Submit ad</h2></a></td>
            </form>
        </tr>
    </table>
</div>
