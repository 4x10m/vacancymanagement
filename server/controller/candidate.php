<?php
require_once "../model/candidature.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();
session_start();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;
	$userid = $_SESSION['userid'];

	if (isset($id, $userid)) {
		$candidature = new Candidature($userid, $id);
		$candidature->save();

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