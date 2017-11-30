<?php

function all_users() {
	$i = 0;
	$sql = mysql_query("SELECT * FROM users");
	$usersCount = @mysql_num_rows($sql);
	if ($usersCount > 0) {
		while ($row = mysql_fetch_array($sql)) {
			$user_id[$i]	= $row['user_id'];
			$username[$i]	= $row['username'];
			$first_name[$i]	= $row['first_name'];
			$email[$i]		= $row['email'];
			$contact[$i]	= $row['contact'];
			$city[$i]		= $row['city'];
			$i = $i + 1;
		}
	} else {
		return 0;	
	}
	return array($user_id, $username, $first_name, $email, $contact, $city);
}

function recover_admin($mode, $email) {
	$mode	= sanitize($mode);
	$email	= sanitize($email);
	
	$admin_data = admin_data(admin_id_from_email($email), 'username');
	
	if ($mode == 'username') {
		mail($email, 'Your username', "Hello " . $admin_data['username']. ",\n\nYour username is: " . $admin_data['username'] . "\n\nFrom: Smart-Store");
	} else if ($mode == 'password'){
		
	}
}
function recover_user($mode, $email) {
	$mode	= sanitize($mode);
	$email	= sanitize($email);
	
	$user_data = user_data(user_id_from_email($email), 'user_id', 'username', 'first_name');
	
	if ($mode == 'username') {
		mail($email, 'Your Username', "Hello " . $user_data['first_name']. ",\n\nYour username is: " . $user_data['username'] . "\n\nFrom: Smart-Store");
	} else if ($mode == 'password'){
		$generated_password = substr(md5(rand(999, 999999)), 0, 8);
		change_password($user_data['user_id'], $generated_password);
		mail($email, 'Your Password Recovery', "Hello " . $user_data['first_name']. ",\n\nYour new password is: " . $generated_password . "\n\nFrom: Smart-Store");
	}
}

function activate($email, $email_code) {
	$email = sanitize($email);
	$email_code = sanitize($email_code);
	
	if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"), 0) == 1) {
		mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
	} else {
		return false;
	}
}

function change_password($user_id, $password) {
	$user_id = (int)$user_id;
	$password = md5($password);
	
	mysql_query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = '$user_id'");
}

function register_user($register_data) {
	array_walk($register_data, 'array_sanitize');
	$register_data['password'] = md5($register_data['password']);
	
	$fields = '`' . implode('`, `', array_keys($register_data)) . '`';
	$data = '\'' . implode('\', \'', $register_data) . '\'';

	mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
	mail($register_data['email'], 'Activate your account', "Hello " . $register_data['username'] . ",\n\nYou need to activate your account, so use the link below:\n\nhttp://ray114.byethost31.com/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\n\n - smart-store");
}

function user_data($user_id) {
	$data = array();
	$user_id = (int)$user_id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1) {
		unset($func_get_args[0]);
		
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id`='$user_id'"));
		return $data;
	}
}

function admin_data($id) {
	$data = array();
	$id = (int)$id;
	
	$func_num_args = func_num_args();
	$func_get_args = func_get_args();
	
	if ($func_num_args > 1) {
		unset($func_get_args[0]);
		
		$fields = '`' . implode('`, `', $func_get_args) . '`';
		$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `admin` WHERE `id`='$id'"));
		return $data;
	}
}

function logged_in() {
	return (isset($_SESSION['user_id'])) ? true : false;
}

function logged_admin() {
	return (isset($_SESSION['admin_id'])) ? true : false;
}

function user_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function admin_exists($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`id`) FROM `admin` WHERE `username` = '$username'");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function email_exists($email) {
	$email = sanitize($email);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_active($username) {
	$username = sanitize($username);
	$query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
	return (mysql_result($query, 0) == 1) ? true : false;
}

function user_id_from_username($username) {
	$username = sanitize($username);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username`='$username'"), 0, 'user_id');
}
function user_id_from_email($email) {
	$email = sanitize($email);
	return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `email`='$email'"), 0, 'user_id');
}
function admin_id_from_email($email) {
	$email = sanitize($email);
	return mysql_result(mysql_query("SELECT `id` FROM `admin` WHERE `email`='$email'"), 0, 'id');
}

function login($username, $password) {
	$user_id = user_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	
	return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username`='$username' AND `password`='$password'"), 0) == 1) ? $user_id :false;
}

function admin_id_from_username($username) {
	$username = sanitize($username);
	return mysql_result(mysql_query("SELECT `id` FROM `admin` WHERE `username`='$username'"), 0, 'id');
}


function log_admin($username, $password) {
	$user_id = admin_id_from_username($username);
	
	$username = sanitize($username);
	$password = md5($password);
	
	return (mysql_result(mysql_query("SELECT COUNT(`id`) FROM `admin` WHERE `username`='$username' AND `password`='$password'"), 0) == 1) ? $user_id :false;
}

?>