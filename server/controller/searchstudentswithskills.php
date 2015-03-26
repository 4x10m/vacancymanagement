<?php
	require_once "../model/user.php";
	require_once "../model/lib/goodserverresponse.php";
	require_once "../model/lib/badserverresponse.php";

	$serveresponse = new BadServerResponse();

	$students = User::searchSkills($_GET['skills']);

	if(!is_array($students)) $serveresponse = new GoodServerResponse(array($students));
	else $serveresponse = new GoodServerResponse($students);

	echo $serveresponse->serializeToJson();
?>