<?php
require_once "../model/user.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();
$styleformat = '<div style="background-color: %s;border: solid 1px;border-radius: 5px;padding-right: 5px;padding-left: 5px;margin-top: 2px;margin-bottom: 2px;">%s</div>';

if(isset($_GET['userid'])) {
	$user = new User($_GET['userid']);

	$graduate = $user->get("graduate");
	$formatedgraduate = $graduate;

	switch ($graduate) {
		case "DUTINFORMATIQUE":
			$formatedgraduate = "DUT Informatique";
			break;
	}

	$serverresponse = new GoodServerResponse($formatedgraduate);
}

echo ($serverresponse->serializeToJSON());
?>