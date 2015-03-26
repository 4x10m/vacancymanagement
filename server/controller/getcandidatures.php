<?php
require_once "../model/candidature.php";
require_once "../model/stage.php";
require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$sr = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;

	if (isset($id)) {
		$sr = new GoodServerResponse(array('values' => Candidature::getCandidatures($id)));
	}
}

echo $sr->serializeToJSON();
?>