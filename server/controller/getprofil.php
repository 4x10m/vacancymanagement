<?php
require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;

	if (isset($id)) {
		$user = new User($id);

		$serverresponse = new GoodServerResponse(array('state' => true, 'values' => array($user->get("username"), $user->get("type"))));
	}
}

echo ($serverresponse->serializeToJSON());
?>