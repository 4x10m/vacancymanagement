<?php
require_once "../model/stage.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

session_start();

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$name = (isset($_GET['name']) and !empty($_GET['name'])) ? $_GET['name'] : null;
	$description = (isset($_GET['description']) and !empty($_GET['description'])) ? $_GET['description'] : null;
	$placenumber = (isset($_GET['placenumber']) and !empty($_GET['placenumber'])) ? $_GET['placenumber'] : null;

	$enterpriseid = $_SESSION['userid'];

	if (isset($name, $description, $placenumber)) {
		$stage = new Stage($name, $description, $enterpriseid, false, $placenumber);
		$stage->save();

		$serverresponse = new GoodServerResponse(array('state' => true));
	} else {
		$serverresponse = new GoodServerResponse(array('state' => false));
	}
} else {
	$serverresponse = new GoodServerResponse(array('state' => false));
}

session_write_close();

echo $serverresponse->serializeToJSON();
?>