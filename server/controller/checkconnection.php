<?php
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

session_start();

if (isset($_SESSION['userid']) and !empty($_SESSION['userid'])) {
	$serverresponse = new GoodServerResponse(array('state' => true));
} else {
	$serverresponse = new GoodServerResponse(array('state' => false));
}

echo ($serverresponse->serializeToJSON());
?>