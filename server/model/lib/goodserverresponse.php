<?php
require_once 'serverresponse.php';

//this class represent a good server response
//it inherit from an abstract server response
//it set it parent status to true
class GoodServerResponse extends ServerResponse {
	public function __construct() {
		$args = func_get_args();

		switch (count($args)) {
			case 0:
				parent::__construct(true, null);

				break;

			case 1:
				if ($args[0] != null) {
					if (is_array($args[0])) {
						parent::__construct(true, $args[0]);
					} else {
						parent::__construct(true, array($args[0]));
					}
				} else {
					parent::__construct(true, null);
				}

				break;

			default:
				parent::__construct(true, $args);
		}
	}
}
?>