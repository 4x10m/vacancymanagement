<?php
	require_once("../model/enterpriseregistration.php");
	require_once("../model/lib/goodserverresponse.php");
	require_once("../model/lib/badserverresponse.php");

	$serveresponse = new BadServerResponse();

	$enterpriseregistrations = EnterpriseRegistration::getUnvalidatedEnterpriseRegistration();

	if($enterpriseregistrations != null) $serveresponse = new GoodServerResponse($enterpriseregistrations);
	else $serveresponse = new GoodServerResponse(null);

	echo $serveresponse->serializeToJson();
?>