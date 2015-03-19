<?php
	require_once("../model/enterpriseregistration.php");
	require_once("../model/lib/goodserverresponse.php");
	require_once("../model/lib/badserverresponse.php");

	$sr = new BadServerResponse();

	if(isset($_GET) and !empty($_GET)) {
		$phonenumbers = (isset($_GET['phonenumbers']) and !empty($_GET['phonenumbers'])) ? json_decode($_GET['phonenumbers']) : null;

		if(isset($phonenumbers)) {
			foreach($phonenumber as $phonenumbers) {
				//lol
				//sendSMS($phonenumber);
			}
		}
	}

	echo $sr->serializeToJSON();
?>