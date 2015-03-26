<?php
require_once "../model/stage.php";
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serveresponse = new BadServerResponse();

$stages = Stage::loadAll();

$serveresponse = new GoodServerResponse($stages);

echo $serveresponse->serializeToJson();
?>