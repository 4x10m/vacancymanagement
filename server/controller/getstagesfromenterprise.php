<?php
require_once "../model/stage.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serveresponse = new BadServerResponse();

session_start();

$stages = Stage::loadAllStageFromEnterprise($_SESSION['userid']);

$serveresponse = new GoodServerResponse($stages);

session_write_close();

echo $serveresponse->serializeToJson();
?>