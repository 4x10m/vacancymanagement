<?php
	require_once("../model/enterpriseregistration.php");
	require_once("../model/lib/goodserverresponse.php");
	require_once("../model/lib/badserverresponse.php");

	$serverresponse = new BadServerResponse();

	if(isset($_GET) and !empty($_GET)) {
		$username = (isset($_GET['username']) and !empty($_GET['username'])) ? $_GET['username'] : null;
		$password = (isset($_GET['password']) and !empty($_GET['password'])) ? $_GET['password'] : null;
		$mail = (isset($_GET['mail']) and !empty($_GET['mail'])) ? $_GET['mail'] : null;
		$website = (isset($_GET['website']) and !empty($_GET['website'])) ? $_GET['website'] : null;

		if(isset($username, $password, $mail, $website)) {
			EnterpriseRegistration::register($username, $password, $mail, $website);
			
			$serverresponse = new GoodServerResponse();
		}
	}

	echo $serverresponse->serializeToJSON();
?>