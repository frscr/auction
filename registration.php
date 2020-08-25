<?php
require_once("modelUser/RegUser.php");
require_once("conn.php");
$user = new RegUser($list_link);
	if(isset($_POST['send_reg'])){
		$st = $user->check_data($_POST['name_user'], $_POST['login_user'], $_POST['psw_user'], $_POST['rpsw_user'],
			$_POST['email_user'], $_POST['remail_user']);
		
	}
require ("forms/form_reg.php");
?>