<?php
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: PUT, GET, POST");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

if (isset($_GET) and !empty($_GET)) {
	$username = (isset($_GET['username']) and !empty($_GET['username'])) ? $_GET['username'] : null;
	$password = (isset($_GET['password']) and !empty($_GET['password'])) ? $_GET['password'] : null;

	if (isset($username, $password)) {
		$user = User::login($username, $password);

		if ($user != null) {
			session_start();
			//session_regenerate_id();

			//$sessionid = session_id();

			//session_destroy();

			//session_name($sessionid);
			//session_start();
			//session_regenerate_id();

			$_SESSION['userid'] = $user->getId();

			session_write_close();

			$serverresponse = new GoodServerResponse($user->getId());
		}
	}
}

echo $serverresponse->serializeToJSON();
?>