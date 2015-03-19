<?php
require_once "../model/studentsession.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$type = (isset($_GET['type']) and !empty($_GET['type'])) ? $_GET['type'] : null;
	$table = (isset($_GET['table']) and !empty($_GET['table'])) ? $_GET['table'] : null;

	if (isset($type, $table)) {
		if ($type = 'EMAIL') {
			foreach ($table as $row) {
				StudentSession::add($row);
			}
		}

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