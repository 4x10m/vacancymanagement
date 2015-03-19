<?php
require_once "../model/stage.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serveresponse = new BadServerResponse();

session_start();

$stages = Stage::loadAllStageFromEnterprise($_SESSION['userid']);

//TODO normally we dont need this if statement
if (is_array($stages[0])) {
	$serveresponse = new GoodServerResponse($stages);
} else {
	$serveresponse = new GoodServerResponse(array($stages));
}

session_write_close();

echo $serveresponse->serializeToJson();
?>