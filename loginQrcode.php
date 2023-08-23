<?php
session_start();
include ("ConfigName.php");
require_once("class.user.php");
$login = new USER();

	$user_tel = strip_tags($_GET['t']); //เบอร์โทร
	$school_code = strip_tags($_GET['sc']);  ///school_code
	$token = strip_tags($_GET['token']);
	$verify_get=sha1(md5($school_code));
	
if($verify_get==$token){


	


	if($login->doLogin($user_tel,$user_tel,$user_tel))
	{
	
		$login->redirect('sdc?pop');
	}
	else
	{
		$error = "Wrong Details !";
	}
}
