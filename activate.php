<?php
include 'init.php';

if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
	echo 'Thanks, we have activated your account.';
} else if (isset($_GET['email'], $_GET['email_code']) === true) {
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	if (email_exists($email) === false) {
		$errors = 'Oops, something went wrong, we could not find that email address.';
	} else if (activate($email, $email_code) === false) {
		$errors = 'We had problem activating your account.';
	}
	if (empty($errors) === false) {
		print_r($errors);
	} else {
		header('Location:activate.php?success');
	}
		
} else {
	header('Location: index.php');
	exit();
}

?>