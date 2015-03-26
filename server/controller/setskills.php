<?php
	require_once "../model/user.php";
	require_once "../model/lib/goodserverresponse.php";
	require_once "../model/lib/badserverresponse.php";

	$serverresponse = new BadServerResponse();

	session_start();

	if(isset($_SESSION['userid']) and isset($_GET['skills'])) {
		$user = new User($_SESSION['userid']);

		$result = $user->setSkills($_GET['skills']);

		$serverresponse = new GoodServerResponse($result);
	}

	echo $serverresponse->serializeToJSON();
?>