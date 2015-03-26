<?php
require_once "../model/stage.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$sr = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;

	if (isset($id)) {
		$er = new Stage($id);

		if ($er->publication()) {
			$sr = new GoodServerResponse(array('state' => true));
		} else {
			$sr = new GoodServerResponse(array('state' => false));
		}
	}
}

echo $sr->serializeToJSON();
?>