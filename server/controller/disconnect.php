<?php
require_once "../model/lib/goodserverresponse.php";
require_once "../model/lib/badserverresponse.php";

$serverresponse = new BadServerResponse();

session_start();
session_destroy();

$serverresponse = new GoodServerResponse();

echo $serverresponse->serializeToJSON();
?>