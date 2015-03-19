<?php
	require_once("../model/user.php");
	require_once("../model/lib/serverresponse.php");

	$serverresponse;

	if(isset($_GET) and !empty($_GET)) {
		$username = (isset($_GET['username']) and !empty($_GET['username'])) ? $_GET['username'] : null;
		$password = (isset($_GET['password']) and !empty($_GET['password'])) ? $_GET['password'] : null;

		if(isset($username, $password)) {
			$user = new User($username, $password);
			$user->save();

			$serverresponse = new ServerResponse('ok');
		}
		else {
			$serverresponse = new ServerResponse('not ok');
		}
	}
	else {
		$serverresponse = new ServerResponse('not ok');
	}

	echo $serverresponse->serializeToJSON();
?>