<?php
require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$sessionid = (isset($_GET['sessionid']) and !empty($_GET['sessionid'])) ? $_GET['sessionid'] : null;

	if (isset($sessionid)) {
		//session_name($sessionid);
		session_start();

		$userid = $_SESSION['userid'];

		session_write_close();

		if (isset($userid) and !empty($userid)) {
			$user = new User($userid);

			$serverresponse = new GoodServerResponse($user->get("username"), $user->get("type"));
		}
	}
}

echo ($serverresponse->serializeToJSON());
?>