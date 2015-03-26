<?php
	require_once("../model/user.php");
	require_once("../model/lib/badserverresponse.php");
	require_once("../model/lib/goodserverresponse.php");

	$serverresponse = new BadServerResponse();

	if(isset($_GET) and !empty($_GET)) {
		$username = (isset($_GET['username']) and !empty($_GET['username'])) ? $_GET['username'] : null;
		$password = (isset($_GET['password']) and !empty($_GET['password'])) ? $_GET['password'] : null;

		if(isset($username, $password)) {
			$cryptedpassword = sha1($password);

			$user = new User($username, $cryptedpassword, 'ADMINISTRATOR');
			$user->save();

			$serverresponse = new GoodServerResponse('ok');
		}
	}

	echo $serverresponse->serializeToJSON();
?>