<?php
	require_once "../model/lib/goodserverresponse.php";
	require_once "../model/lib/badserverresponse.php";

	$serverresponse = new BadServerResponse();

	session_start();

	if(isset($_SESSION['userid']) and !empty($_SESSION['userid']) and $_SESSION['userid'] > 0) {
		$serverresponse = new GoodServerResponse(array('id' => $_SESSION['userid']));
	}

	echo ($serverresponse->serializeToJSON());
?>