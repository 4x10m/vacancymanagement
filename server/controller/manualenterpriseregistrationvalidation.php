<?php
require_once "../model/enterpriseregistration.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$sr = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;

	if (isset($id)) {
		$er = new EnterpriseRegistration($id);

		if ($er->manualValidation()) {
			$sr = new GoodServerResponse(array('state' => true));
		} else {
			$sr = new GoodServerResponse(array('state' => false));
		}
	}
}

echo $sr->serializeToJSON();
?>