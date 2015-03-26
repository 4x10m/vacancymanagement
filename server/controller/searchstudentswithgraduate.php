<?php
	require_once "../model/user.php";
	require_once "../model/lib/goodserverresponse.php";
	require_once "../model/lib/badserverresponse.php";

	$serveresponse = new BadServerResponse();

	$students = User::searchGraduate($_GET['graduate']);

	if(!is_array($students)) $serveresponse = new GoodServerResponse(array($students));
	else $serveresponse = new GoodServerResponse($students);

	echo $serveresponse->serializeToJson();
?>