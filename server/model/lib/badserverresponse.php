<?php
	require_once('serverresponse.php');

	//this class represent a bad server response
	//it inherit from an abstract server response
	//and set it status to false
	class BadServerResponse extends ServerResponse {
		public function __construct() {
			$args = func_get_args();
        	$argsnumber = func_num_args();

        	if($argsnumber == 0) parent::__construct(false);
			else throw new InvalidArgumentException(sprintf('error in bad server response initialization : attempt for 0 argument, receive %d arguments' , $argsnumber));
		}
	}
?>