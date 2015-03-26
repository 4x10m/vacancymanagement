<?php
require_once "../model/gcmuser.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$registrationid = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;
	$name = (isset($_GET['name']) and !empty($_GET['name'])) ? $_GET['name'] : null;

	if (isset($registrationid, $name)) {
		$result = GCMUser::storeUser($name, $registrationid);

		$message = array("product" => "shirt");

		$serverresponse = new GoodServerResponse(array('state' => true));
	}

	$serverresponse = new GoodServerResponse(array('state' => false));
}

echo ($serverresponse->serializeToJSON());
?>