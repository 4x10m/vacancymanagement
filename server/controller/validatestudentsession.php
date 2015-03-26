<?php
require_once "../model/studentsession.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$sr = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$id = (isset($_GET['id']) and !empty($_GET['id'])) ? $_GET['id'] : null;
	$code = (isset($_GET['code']) and !empty($_GET['code'])) ? $_GET['code'] : null;
	$password = (isset($_GET['password']) and !empty($_GET['password'])) ? $_GET['password'] : null;

	if (isset($id, $code)) {
		$er = new StudentSession($id);

		if ($er->validate($code, $password)) {
			$sr = new GoodServerResponse(array('state' => true));
		} else {
			$sr = new GoodServerResponse(array('state' => false));
		}
	}
}

echo $sr->serializeToJSON();
?>