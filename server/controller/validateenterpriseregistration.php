<?php
	require_once("../model/enterpriseregistration.php");
	require_once("../model/lib/goodserverresponse.php");
	require_once("../model/lib/badserverresponse.php");

	$sr = new BadServerResponse();

	if(isset($_GET) and !empty($_GET)) {
		$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;
		$code = (isset($_GET['code']) and !empty($_GET['code'])) ? $_GET['code'] : null;

		if(isset($id, $code)) {
			$er = new EnterpriseRegistration($id);

			if($er->validate($code)) $sr = new GoodServerResponse();
		}
	}

	echo $sr->serializeToJSON();
?>