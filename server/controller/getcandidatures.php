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
		$er = Candidature::getCandidatures($id);

		if (is_array($er[0])) {
			$sr = new GoodServerResponse(array('state' => true, 'values' => $er));
		} else {
			$sr = new GoodServerResponse(array('state' => true, 'values' => array($er)));
		}
	}
}

echo $sr->serializeToJSON();
?>