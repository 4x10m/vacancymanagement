<?php
//This class represent a response from server
//it must be serialized to json to be send to client
//status : true if the request was good, false if not
//values : values to be send to client
abstract class ServerResponse {
	protected $status;
	private $values;

	public function getStatus() {
		return $this->status;
	}

	public function getValues() {
		return $this->values;
	}

	public function setValues($values) {
		$this->values = $values;
	}

	function __construct() {
		$args = func_get_args();
		$argsnumber = func_num_args();

		switch ($argsnumber) {
			case 1:
				if (is_array($args[0])) {
					$this->status = $args[0][0];
					$this->setValues($args[0][1]);
				} else {
					$this->status = $args[0];
				}

				break;
			case 2:
				$this->status = $args[0];
				$this->setValues($args[1]);

				break;
		}
	}

	public function serializeToJson() {
		$transformedrows;

		if (is_array($this->getValues())) {
			$transformedrows = array();

			foreach ($this->getValues() as $key => $value) {
				if (is_object($value)) {
					array_push($transformedrows, $value->serialize());
				} else {
					$transformedrows[$key] = $value;
				}
			}
		} else {
			$transformedrows = $this->getValues();
		}

		$jsonarray = array('status' => $this->getStatus(), 'values' => $transformedrows);

		return json_encode($jsonarray);
	}
}
?>