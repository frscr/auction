<?php
//require_once("modelUser/AuthUser.php");
if(isset($_POST['send_auth'])){
	$auth = new AuthUser($list_link);
	$auth->check_data($_POST['login'], $_POST['psw']);
	header('Location: index.php');
}

require("forms/form_auth.php");
?>