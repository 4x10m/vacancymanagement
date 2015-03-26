<?php
require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

session_start();

$user = new User($_SESSION['userid']);

$serverresponse = new GoodServerResponse(array('state' => true, 'values' => array($user->get("name"), $user->get("type"), $user->get("graduate"))));

session_write_close();

echo ($serverresponse->serializeToJSON());
?>